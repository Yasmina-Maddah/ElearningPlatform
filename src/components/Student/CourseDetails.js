import React, { useEffect, useState } from "react";
import { getCourseDetails } from "../../api/courseService";

const CourseDetails = ({ courseId }) => {
    const [course, setCourse] = useState(null);

    useEffect(() => {
        const fetchCourseDetails = async () => {
            try {
                const data = await getCourseDetails(courseId);
                setCourse(data.course);
            } catch (error) {
                console.error("Error fetching course details:", error);
            }
        };

        fetchCourseDetails();
    }, [courseId]);

    if (!course) {
        return <p>Loading course details...</p>;
    }

    return (
        <div>
            <h1>{course.title}</h1>
            <p>{course.description}</p>
            <h2>Announcements</h2>
            <ul>
                {course.announcements.map((announcement) => (
                    <li key={announcement.id}>{announcement.content}</li>
                ))}
            </ul>
            <h2>Assignments</h2>
            <ul>
                {course.assignments.map((assignment) => (
                    <li key={assignment.id}>{assignment.title}</li>
                ))}
            </ul>
        </div>
    );
};

export default CourseDetails;