import React from "react";

const StudentDashboard = () => {
    return <h1>Welcome to the Student Dashboard</h1>;
};

const handleLogout = () => {
    localStorage.clear();
    navigate("/");
};

export default StudentDashboard;