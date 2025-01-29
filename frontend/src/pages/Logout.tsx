import React from "react";
import { useAuth } from "../context/AuthContext";

const Logout: React.FC = () => {
  const { logoutUser } = useAuth();

  return <button onClick={logoutUser}>Logout</button>;
};

export default Logout;
