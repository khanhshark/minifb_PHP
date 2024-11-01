DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS comments;

CREATE TABLE users (
		id INTEGER NOT NULL AUTO_INCREMENT,
	     username CHAR(255) NOT NULL,
	     password VARCHAR(512) NOT NULL,
	     fullname VARCHAR(256) NOT NULL,
	     role INTEGER ,
	     status INTEGER,
	     PRIMARY KEY (id)

);
ALTER TABLE users ADD UNIQUE INDEX username(username); -- Đảm bảo không có tên đăng nhập trùng nhau
ALTER TABLE users
ADD COLUMN profile_picture VARCHAR(255);
ALTER TABLE users
ADD COLUMN mobile VARCHAR(255);
CREATE TABLE posts (
		id INTEGER NOT NULL AUTO_INCREMENT,
	     userId INTEGER,
	     message TEXT, -- nội dung của bài đăng
	     index posts_userId(userId),
	     created_at DATETIME, -- thời gian tạo bài đăng 
	     updated_at DATETIME, -- thời gian cập nhật bài đăng 
	     FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE, -- nếu người dùng bị xóa thì bài đăng sẽ bị xóa theo
	     PRIMARY KEY (id)

);
ALTER TABLE posts
ADD COLUMN post_picture VARCHAR(255);


CREATE TABLE comments (
		id INTEGER NOT NULL AUTO_INCREMENT,
	     userId INTEGER,
	     postId INTEGER,
	     comment TEXT,
	     index comment_userId(userId),
	     index comment_postId(postId),
	     created_at DATETIME,
	     updated_at DATETIME,
	     FOREIGN KEY (postId) REFERENCES posts(id) ON DELETE CASCADE,
	     FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
	     PRIMARY KEY (id)

);

INSERT INTO users SET username='admin',password=PASSWORD('admin@secad'),fullname='Admin Secad',role=1,status=1;

CREATE TABLE chatauth (
	     token VARCHAR(256), -- lưu trữ ma token
	     userId INTEGER,	   
	     expired_at BIGINT,	  -- thời gian hết hạn của mã token
	     FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,   
	     PRIMARY KEY (token)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID duy nhất cho mỗi tin nhắn
    sender_id INT,                             -- ID của người gửi tin nhắn
    receiver_id INT,                           -- ID của người nhận tin nhắn
    message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, -- Nội dung tin nhắn hỗ trợ tiếng Việt
    image_path VARCHAR(255) DEFAULT NULL,      -- Đường dẫn tới hình ảnh (nếu có)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Thời gian gửi tin nhắn
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,  -- Khóa ngoại tham chiếu tới bảng users
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE -- Khóa ngoại tham chiếu tới bảng users
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
