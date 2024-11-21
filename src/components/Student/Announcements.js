import React, { useEffect, useState } from "react";
import { getAnnouncements } from "../../api/announcementService";

const Announcements = ({ courseId }) => {
    const [announcements, setAnnouncements] = useState([]);

    useEffect(() => {
        const fetchAnnouncements = async () => {
            try {
                const data = await getAnnouncements(courseId);
                setAnnouncements(data.announcements);
            } catch (error) {
                console.error("Error fetching announcements:", error);
            }
        };

        fetchAnnouncements();
    }, [courseId]);

    return (
        <div>
            <h1>Announcements</h1>
            <ul>
                {announcements.map((announcement) => (
                    <li key={announcement.id}>{announcement.content}</li>
                ))}
            </ul>
        </div>
    );
};

export default Announcements;