import React from "react";
import { useNavigate } from "react-router-dom";

const AdminDashboard = () => {
    const navigate = useNavigate();

    const handleLogout = () => {
        localStorage.clear();
        navigate("/"); 
    };

    return (
        <div>
            <h1>Welcome to the Admin Dashboard</h1>
            <button onClick={handleLogout}>Logout</button>
        </div>
    );
};

export default AdminDashboard;