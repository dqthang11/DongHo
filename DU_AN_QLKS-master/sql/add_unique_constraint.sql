-- Thêm ràng buộc UNIQUE cho trường name trong bảng rooms
ALTER TABLE rooms
ADD CONSTRAINT unique_room_name UNIQUE (name); 