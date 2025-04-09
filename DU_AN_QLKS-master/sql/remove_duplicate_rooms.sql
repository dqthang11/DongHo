-- Tạo bảng tạm để lưu các ID cần giữ lại (bản ghi đầu tiên của mỗi tên phòng)
CREATE TEMPORARY TABLE temp_rooms AS
SELECT MIN(id) as id
FROM rooms
GROUP BY name;

-- Xóa tất cả các bản ghi không có trong bảng tạm (các bản sao)
DELETE FROM rooms 
WHERE id NOT IN (SELECT id FROM temp_rooms);

-- Xóa bảng tạm
DROP TEMPORARY TABLE IF EXISTS temp_rooms; 