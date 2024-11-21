import api from "./api"; 

export const getAnnouncements = async (courseId) => {
    const response = await api.get(`/announcements/getAnnouncements.php?courseId=${courseId}`);
    return response.data;
};

export const postAnnouncement = async (announcementData) => {
    const response = await api.post("/announcements/postAnnouncement.php", announcementData);
    return response.data;
};

export const deleteAnnouncement = async (announcementId) => {
    const response = await api.delete("/announcements/deleteAnnouncement.php", {
        data: { announcementId },
    });
    return response.data;
};