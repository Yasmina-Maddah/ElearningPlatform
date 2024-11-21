import React, { useEffect, useState } from "react";
import { getAllCourses } from "../../api/courseService";

const InstructorDashboard = () => {
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
            <h1>Instructor Dashboard</h1>
            <h2>Your Courses</h2>
            <ul>
                {courses.map((course) => (
                    <li key={course.id}>{course.title}</li>
                ))}
            </ul>
        </div>
    );
};

export default InstructorDashboard;