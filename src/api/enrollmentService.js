import api from "./api";

export const enrollInCourse = async (courseId) => {
    const response = await api.post("/enrollments/enroll.php", { courseId });
    return response.data;
};

export const getEnrolledStudents = async (courseId) => {
    const response = await api.get(`/enrollments/getEnrollments.php?courseId=${courseId}`);
    return response.data;
};

export const removeEnrollment = async (courseId, studentId) => {
    const response = await api.delete("/enrollments/removeEnrollment.php", {
        data: { courseId, studentId },
    });
    return response.data;
};