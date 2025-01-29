import React from "react";
import { Navigate, Outlet } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const ProtectedRoute: React.FC<{ guestOnly?: boolean }> = ({ guestOnly = false }) => {
  const { isAuthenticated } = useAuth();

  if (guestOnly && isAuthenticated) {
    return <Navigate to="/" />;
  }

  if (!guestOnly && !isAuthenticated) {
    return <Navigate to="/login" />;
  }

  return <Outlet />;
};

export default ProtectedRoute;
