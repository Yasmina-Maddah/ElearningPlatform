import React, { useState, useEffect } from "react";
import { getAllCourses, createCourse, editCourse, deleteCourse } from "../../api/courseService";

const ManageCourses = () => {
    const [courses, setCourses] = useState([]);
    const [newCourse, setNewCourse] = useState({ title: "", description: "" });
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

    const handleCreate = async () => {
        try {
            const data = await createCourse(newCourse);
            setMessage(data.message);
            setCourses([...courses, data.course]);
        } catch (error) {
            setMessage("Error creating course.");
        }
    };

    const handleEdit = async (courseId, updatedData) => {
        try {
            const data = await editCourse({ id: courseId, ...updatedData });
            setMessage(data.message);
            setCourses(
                courses.map((course) => (course.id === courseId ? { ...course, ...updatedData } : course))
            );
        } catch (error) {
            setMessage("Error editing course.");
        }
    };

    const handleDelete = async (courseId) => {
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
            <div>
                <h2>Create Course</h2>
                <input
                    type="text"
                    placeholder="Title"
                    value={newCourse.title}
                    onChange={(e) => setNewCourse({ ...newCourse, title: e.target.value })}
                />
                <input
                    type="text"
                    placeholder="Description"
                    value={newCourse.description}
                    onChange={(e) => setNewCourse({ ...newCourse, description: e.target.value })}
                />
                <button onClick={handleCreate}>Create Course</button>
            </div>
            <h2>Existing Courses</h2>
            <ul>
                {courses.map((course) => (
                    <li key={course.id}>
                        {course.title}
                        <button onClick={() => handleEdit(course.id, { title: "Updated Title" })}>
                            Edit
                        </button>
                        <button onClick={() => handleDelete(course.id)}>Delete</button>
                    </li>
                ))}
            </ul>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ManageCourses;