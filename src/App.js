import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./components/Auth/Login";
import Register from "./components/Auth/Register";
import StudentDashboard from "./components/Student/Dashboard";
import BrowseCourses from "./components/Student/BrowseCourses";
import CourseDetailsStudent from "./components/Student/CourseDetails";
import AssignmentsStudent from "./components/Student/Assignments";
import AnnouncementsStudent from "./components/Student/Announcements";
import InstructorDashboard from "./components/Instructor/Dashboard";
import ManageCourses from "./components/Instructor/ManageCourses";
import CourseDetailsInstructor from "./components/Instructor/CourseDetails";
import AssignmentsInstructor from "./components/Instructor/Assignments";
import AnnouncementsInstructor from "./components/Instructor/Announcements";
import ProtectedRoute from "./components/ProtectedRoute";

const App = () => {
    return (
        <Router>
            <Routes>
                {/* Public Routes */}
                <Route path="/" element={<Login />} />
                <Route path="/register" element={<Register />} />

                {/* Student Routes */}
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
                    path="/course-details/student/:courseId"
                    element={
                        <ProtectedRoute role="student">
                            <CourseDetailsStudent />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/assignments/student/:courseId"
                    element={
                        <ProtectedRoute role="student">
                            <AssignmentsStudent />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/announcements/student/:courseId"
                    element={
                        <ProtectedRoute role="student">
                            <AnnouncementsStudent />
                        </ProtectedRoute>
                    }
                />

                {/* Instructor Routes */}
                <Route
                    path="/instructor-dashboard"
                    element={
                        <ProtectedRoute role="instructor">
                            <InstructorDashboard />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/manage-courses"
                    element={
                        <ProtectedRoute role="instructor">
                            <ManageCourses />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/course-details/instructor/:courseId"
                    element={
                        <ProtectedRoute role="instructor">
                            <CourseDetailsInstructor />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/assignments/instructor/:courseId"
                    element={
                        <ProtectedRoute role="instructor">
                            <AssignmentsInstructor />
                        </ProtectedRoute>
                    }
                />
                <Route
                    path="/announcements/instructor/:courseId"
                    element={
                        <ProtectedRoute role="instructor">
                            <AnnouncementsInstructor />
                        </ProtectedRoute>
                    }
                />
            </Routes>
        </Router>
    );
};

export default App;