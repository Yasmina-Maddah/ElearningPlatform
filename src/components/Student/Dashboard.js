import React, { useEffect, useState } from "react";
import { getAllCourses } from "../../api/courseService";

const StudentDashboard = () => {
    const [courses, setCourses] = useState([]);

    useEffect(() => {
        const fetchCourses = async () => {
            try {
                const data = await getAllCourses();
                setCourses(data.courses);
            } catch (error) {
                console.error("Error fetching courses:", error);
            }
        };

        fetchCourses();
    }, []);

    return (
        <div>
            <h1>Student Dashboard</h1>
            <h2>Enrolled Courses</h2>
            <ul>
                {courses.map((course) => (
                    <li key={course.id}>{course.title}</li>
                ))}
            </ul>
        </div>
    );
};

export default StudentDashboard;