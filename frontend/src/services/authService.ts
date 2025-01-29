import api from "./api";

// Register user
export const register = async (userData: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}) => {
    return api.post("/auth/register", userData);
};

// Login user
export const login = async (credentials: {
    email: string;
    password: string;
}) => {
    const response = await api.post("/auth/login", credentials);
    console.log(response.data.data, 'login...');
    if (response.data.data?.token) {
        localStorage.setItem("token", response.data.data?.token);
    }
    return response;
};

// Logout user
export const logout = async () => {
    try {
        await api.post("/auth/logout");
    } catch (error) {
        console.error("Error logging out:", error);
    } finally {
        localStorage.removeItem("token");
    }
};

// Get user profile
export const getProfile = async () => {
    return api.get("/profile");
};

// Update user profile
export const updateProfile = async (profileData: any) => {
    return api.put("/profile", profileData);
};

// Get user preferences
export const getPreferences = async () => {
    return api.get("/preferences");
};

// Update user preferences
export const updatePreferences = async (preferenceData: any) => {
    return api.put("/preferences", preferenceData);
};
