import api from "./api"; 
export const getAssignments = async (courseId) => {
    const response = await api.get(`/assignments/getAssignments.php?courseId=${courseId}`);
    return response.data;
};

export const submitAssignment = async (submissionData) => {
    const response = await api.post("/assignments/submitAssignment.php", submissionData);
    return response.data;
};

export const gradeSubmission = async (gradingData) => {
    const response = await api.put("/assignments/gradeSubmission.php", gradingData);
    return response.data;
};

export const getSubmissions = async (assignmentId) => {
    const response = await api.get(`/assignments/getSubmissions.php?assignmentId=${assignmentId}`);
    return response.data;
};