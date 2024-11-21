import api from "./api";

export const getAllCourses = async () => {
    const response = await api.get("/courses/getAllCourses.php");
    return response.data;
};

export const getCourseDetails = async (courseId) => {
    const response = await api.get(`/courses/getCourseDetails.php?courseId=${courseId}`);
    return response.data;
};

export const createCourse = async (courseData) => {
    const response = await api.post("/courses/createCourse.php", courseData);
    return response.data;
};

export const editCourse = async (courseData) => {
    const response = await api.put("/courses/editCourse.php", courseData);
    return response.data;
};

export const deleteCourse = async (courseId) => {
    const response = await api.delete("/courses/deleteCourse.php", {
        data: { courseId },
    });
    return response.data;
};