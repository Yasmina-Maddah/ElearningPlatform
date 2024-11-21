import React from "react";

const InstructorDashboard = () => {
    return <h1>Welcome to the Instructor Dashboard</h1>;
};

const handleLogout = () => {
    localStorage.clear();
    navigate("/");
};

export default InstructorDashboard;