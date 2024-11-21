import React, { useState, useEffect } from "react";
import { getAllCourses, deleteCourse } from "../../api/courseService";

const ManageCourses = () => {
    const [courses, setCourses] = useState([]);
    const [message, setMessage] = useState("");

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

    const handleDeleteCourse = async (courseId) => {
        try {
            const data = await deleteCourse(courseId);
            setMessage(data.message);
            setCourses(courses.filter((course) => course.id !== courseId));
        } catch (error) {
            setMessage("Error deleting course.");
        }
    };

    return (
        <div>
            <h1>Manage Courses</h1>
            <ul>
                {courses.map((course) => (
                    <li key={course.id}>
                        {course.title}
                        <button onClick={() => handleDeleteCourse(course.id)}>Delete</button>
                    </li>
                ))}
            </ul>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ManageCourses;