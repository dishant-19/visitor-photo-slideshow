-- Optional: sample visitors and photos for testing. Import AFTER database.sql.
USE visitor_photo_slideshow;
INSERT IGNORE INTO visitors(code,name,email,privacy_consent,display_consent,visits) VALUES
('VSAMPLE01','Amelia Hart','amelia.sample@example.com',1,1,1),('VSAMPLE02','Noah Bennett','noah.sample@example.com',1,1,2),
('VSAMPLE03','Sofia Rossi','sofia.sample@example.com',1,1,1),('VSAMPLE04','Liam Carter','liam.sample@example.com',1,1,1);
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-1.jpg','sample-1.jpg','approved','Portrait' FROM visitors WHERE code='VSAMPLE01';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-2.jpg','sample-2.jpg','approved','Event' FROM visitors WHERE code='VSAMPLE01';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-3.jpg','sample-3.jpg','approved','Group' FROM visitors WHERE code='VSAMPLE02';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-4.jpg','sample-4.jpg','approved','Family' FROM visitors WHERE code='VSAMPLE02';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-5.jpg','sample-5.jpg','approved','General' FROM visitors WHERE code='VSAMPLE03';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-6.jpg','sample-6.jpg','approved','Event' FROM visitors WHERE code='VSAMPLE03';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-7.jpg','sample-7.jpg','approved','Portrait' FROM visitors WHERE code='VSAMPLE04';
INSERT IGNORE INTO photos(visitor_id,filename,original,status,category) SELECT id,'sample-8.jpg','sample-8.jpg','approved','Other' FROM visitors WHERE code='VSAMPLE04';
