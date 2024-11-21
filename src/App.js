import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./components/Auth/Login";
import Register from "./components/Auth/Register";
import StudentDashboard from "./components/Student/Dashboard";
import BrowseCourses from "./components/Student/BrowseCourses";
import CourseDetails from "./components/Student/CourseDetails";
import Assignments from "./components/Student/Assignments";
import Announcements from "./components/Student/Announcements";
import InstructorDashboard from "./pages/Dashboard/InstructorDashboard";
import AdminDashboard from "./pages/Dashboard/AdminDashboard";
import ProtectedRoute from "./components/ProtectedRoute";

const App = () => {
    return (
        <Router>
            <Routes>
                {/* Public Routes */}
                <Route path="/" element={<Login />} />
                <Route path="/register" element={<Register />} />

                {/* Protected Routes */}
                {/* Student Pages */}
                <Route
                    path="/student-dashboard"
                    element={
                        <ProtectedRoute role="student">
                            <StudentDashboard />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/browse-courses"
                    element={
                        <ProtectedRoute role="student">
                            <BrowseCourses />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/course-details/:courseId"
                    element={
                        <ProtectedRoute role="student">
                            <CourseDetails />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/assignments/:courseId"
                    element={
                        <ProtectedRoute role="student">
                            <Assignments />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/announcements/:courseId"
                    element={
                        <ProtectedRoute role="student">
                            <Announcements />
                        </ProtectedRoute>
                    }
                />

                {/* Instructor Pages */}
                <Route
                    path="/instructor-dashboard"
                    element={
                        <ProtectedRoute role="instructor">
                            <InstructorDashboard />
                        </ProtectedRoute>
                    }
                />

                {/* Admin Pages */}
                <Route
                    path="/admin-dashboard"
                    element={
                        <ProtectedRoute role="admin">
                            <AdminDashboard />
                        </ProtectedRoute>
                    }
                />
            </Routes>
        </Router>
    );
};

export default App;