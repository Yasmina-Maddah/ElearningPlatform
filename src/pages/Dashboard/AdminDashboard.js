import React from "react";

const AdminDashboard = () => {
    return <h1>Welcome to the Admin Dashboard</h1>;
};

const handleLogout = () => {
    localStorage.clear();
    navigate("/");
};

export default AdminDashboard;