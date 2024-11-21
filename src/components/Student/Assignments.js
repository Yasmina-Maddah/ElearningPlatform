import React, { useEffect, useState } from "react";
import { getAssignments, submitAssignment } from "../../api/assignmentService";

const Assignments = ({ courseId }) => {
    const [assignments, setAssignments] = useState([]);
    const [message, setMessage] = useState("");

    useEffect(() => {
        const fetchAssignments = async () => {
            try {
                const data = await getAssignments(courseId);
                setAssignments(data.assignments);
            } catch (error) {
                console.error("Error fetching assignments:", error);
            }
        };

        fetchAssignments();
    }, [courseId]);

    const handleSubmit = async (assignmentId) => {
        try {
            const data = await submitAssignment({ assignmentId, submission: "My submission" });
            setMessage(data.message);
        } catch (error) {
            setMessage("Error submitting assignment.");
        }
    };

    return (
        <div>
            <h1>Assignments</h1>
            <ul>
                {assignments.map((assignment) => (
                    <li key={assignment.id}>
                        {assignment.title}
                        <button onClick={() => handleSubmit(assignment.id)}>Submit</button>
                    </li>
                ))}
            </ul>
            {message && <p>{message}</p>}
        </div>
    );
};

export default Assignments;