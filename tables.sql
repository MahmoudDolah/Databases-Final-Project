CREATE DATABASE datastore;

USE datastore;

CREATE TABLE member (username VARCHAR(16), 
					password CHAR(32),
					email VARCHAR(30),
					registration_date DATE,
					user_class VARCHAR(5),
					rep_points INT,
					posts INT,
					CONSTRAINT pk_member PRIMARY KEY (username)
					  );
					  
CREATE TABLE forum (title VARCHAR(30), 
					description VARCHAR(200),
					thread_count INT,
					CONSTRAINT pk_forum PRIMARY KEY (title)
					  );
					  
CREATE TABLE thread (subject VARCHAR(50), 
					content MEDIUMTEXT,
					post_count INT,
					threadID INT,
					forum VARCHAR(30), 
					author VARCHAR(16),
					CONSTRAINT pk_threadID PRIMARY KEY (threadID),
                    FOREIGN KEY (forum) REFERENCES forum(title)
					  ON DELETE CASCADE,
					FOREIGN KEY (author) REFERENCES member(username)
                      ON DELETE CASCADE
					  );
					  
CREATE TABLE post (message MEDIUMTEXT, 
					thread_id INT, 
					author VARCHAR(16),
					post_number INT,
					postID INT,
					CONSTRAINT pk_post PRIMARY KEY (postID),
					FOREIGN KEY (author) REFERENCES member(username)
					  ON DELETE CASCADE,
					FOREIGN KEY (thread_id) REFERENCES thread(threadID)
                      ON DELETE CASCADE
					  );
					  
CREATE TABLE stats (total_posts INT,
					total_threads INT,
					total_users INT,
					id INT
					  );			  

INSERT INTO forum (title, description, thread_count) VALUES ("General", "A place for general topics, chats, etc.", 0);
INSERT INTO forum (title, description, thread_count) VALUES ("News", "Talk and gossip about the latest current events.", 0);
					  
INSERT INTO member (username, password, email, registration_date, user_class, rep_points, posts) VALUES ('redleader', '9cdfb439c7876e703e307864c9167a15', 'lol@gmail.com', CURDATE(), 'user', 0, 0);


INSERT INTO thread (subject, content, post_count, threadID, forum, author) VALUES ("Welcome to the forum!", "Hello, I'm the admin and I'd like to welcome you to these parts.", 0, 1, "General", "redleader");

INSERT INTO post (message, thread_id, author, post_number, postID) VALUES ("Thank you, self!", 1, "redleader", 1, 1);

INSERT INTO stats (total_posts, total_threads, total_users, id) VALUES (0, 0, 0, 0);