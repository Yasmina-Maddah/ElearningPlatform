import React, { useState, useEffect } from "react";
import { getAllCourses } from "../../api/courseService";
import { enrollInCourse } from "../../api/enrollmentService";

const BrowseCourses = () => {
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

    const handleEnroll = async (courseId) => {
        try {
            const data = await enrollInCourse(courseId);
            setMessage(data.message);
        } catch (error) {
            setMessage("Error enrolling in course.");
        }
    };

    return (
        <div>
            <h1>Browse Courses</h1>
            <ul>
                {courses.map((course) => (
                    <li key={course.id}>
                        {course.title}
                        <button onClick={() => handleEnroll(course.id)}>Enroll</button>
                    </li>
                ))}
            </ul>
            {message && <p>{message}</p>}
        </div>
    );
};

export default BrowseCourses;