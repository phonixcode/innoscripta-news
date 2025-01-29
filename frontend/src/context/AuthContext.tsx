import React, { createContext, useContext, useEffect, useState } from "react";
import {
  login,
  logout,
  register,
  getProfile,
  updateProfile,
  getPreferences,
  updatePreferences,
} from "../services/authService";

interface AuthContextType {
  user: any;
  preferences: any;
  isAuthenticated: boolean;
  loginUser: (credentials: {
    email: string;
    password: string;
  }) => Promise<void>;
  registerUser: (userData: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
  }) => Promise<void>;
  logoutUser: () => void;
  updateUserProfile: (profileData: any) => Promise<void>;
  updateUserPreferences: (preferenceData: any) => Promise<void>;
}

const AuthContext = createContext<AuthContextType | null>(null);

export const AuthProvider: React.FC<{ children: React.ReactNode }> = ({
  children,
}) => {
  const [user, setUser] = useState<any>(null);
  const [preferences, setPreferences] = useState<any>(null);
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(
    !!localStorage.getItem("token")
  );

  useEffect(() => {
    if (isAuthenticated) {
      fetchProfile();
      fetchPreferences();
    }
  }, [isAuthenticated]);

  const fetchProfile = async () => {
    try {
      const response = await getProfile();
      setUser(response.data);
    } catch (error) {
      console.error("Failed to fetch user profile", error);
      logoutUser();
    }
  };

  const fetchPreferences = async () => {
    try {
      const response = await getPreferences();
      setPreferences(response.data);
    } catch (error) {
      console.error("Failed to fetch preferences", error);
    }
  };

  const loginUser = async (credentials: {
    email: string;
    password: string;
  }) => {
    return login(credentials)
      .then(() => {
        setIsAuthenticated(true);
        fetchProfile();
        fetchPreferences();
      })
      .catch((error: any) => {
        if (error.response && error.response.status === 422) {
          throw error;
        } else {
          throw new Error("Login failed");
        }
      });
  };

  const registerUser = async (userData: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
  }) => {
    return register(userData)
      .then(() =>
        loginUser({ email: userData.email, password: userData.password })
      )
      .catch((error) => {
        if (error.response && error.response.status === 422) {
          throw error;
        } else {
          throw new Error("Registration failed. Please try again.");
        }
      });
  };

  const logoutUser = () => {
    logout();
    setUser(null);
    setPreferences(null);
    setIsAuthenticated(false);
  };

  const updateUserProfile = async (profileData: any) => {
    return updateProfile(profileData)
      .then(() => fetchProfile())
      .catch((error) => {
        if (error.response && error.response.status === 422) {
          throw error;
        } else {
          throw new Error("Failed to update profile.");
        }
      });
  };

  const updateUserPreferences = async (preferenceData: any) => {
    // try {
    //   await updatePreferences(preferenceData);
    //   fetchPreferences();
    // } catch (error) {
    //   console.error("Failed to update preferences", error);
    // }

    return updatePreferences(preferenceData)
      .then(() => fetchPreferences())
      .catch((error) => {
        if (error.response && error.response.status === 422) {
          throw error;
        } else {
          throw new Error("Failed to update preferences.");
        }
      });
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        preferences,
        isAuthenticated,
        loginUser,
        registerUser,
        logoutUser,
        updateUserProfile,
        updateUserPreferences,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within an AuthProvider");
  }
  return context;
};
