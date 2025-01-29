import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "../pages/Login";
import Register from "../pages/Register";
import UserProfile from "../pages/UserProfile";
import UserPreferences from "../pages/UserPreferences";
import PersonalizedFeed from "../pages/PersonalizedFeed";
import ProtectedRoute from "./ProtectedRoute";
import Navbar from "../components/Navbar";
import Home from "../pages/Home";

const AppRoutes = () => {
  return (
    <Router>
      <Navbar />

      <Routes>
        {/* Public Routes */}
        <Route path="/" element={<Home />} />

        <Route element={<ProtectedRoute guestOnly />}>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        </Route>

        {/* Private Routes */}
        <Route element={<ProtectedRoute />}>
          <Route path="/profile" element={<UserProfile />} />
          <Route path="/preferences" element={<UserPreferences />} />
          <Route path="/personalized-feed" element={<PersonalizedFeed />} />
        </Route>
      </Routes>
    </Router>
  );
};

export default AppRoutes;
