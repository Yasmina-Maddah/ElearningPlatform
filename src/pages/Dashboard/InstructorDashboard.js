import React from "react";
import { useNavigate } from "react-router-dom";

const InstructorDashboard = () => {
    const navigate = useNavigate();

    const handleLogout = () => {
        localStorage.clear();
        navigate("/"); 
    };

    return (
        <div>
            <h1>Welcome to the Instructor Dashboard</h1>
            <button onClick={handleLogout}>Logout</button>
        </div>
    );
};

export default InstructorDashboard;