import React, { useEffect, useState } from "react";
import { getPlatformStats } from "../../api/adminService";

const AdminDashboard = () => {
    const [stats, setStats] = useState({ users: 0, courses: 0, enrollments: 0 });

    useEffect(() => {
        const fetchStats = async () => {
            try {
                const data = await getPlatformStats();
                setStats(data.stats);
            } catch (error) {
                console.error("Error fetching platform stats:", error);
            }
        };

        fetchStats();
    }, []);

    return (
        <div>
            <h1>Admin Dashboard</h1>
            <div>
                <p>Total Users: {stats.users}</p>
                <p>Total Courses: {stats.courses}</p>
                <p>Total Enrollments: {stats.enrollments}</p>
            </div>
        </div>
    );
};

export default AdminDashboard;