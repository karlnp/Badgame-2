-- banners
create table if not exists smf_bg2_banners (
  id mediumint primary key auto_increment,
  id_uploader mediumint not null references smf_members(id_member),
  upload_time int(10) not null,
  filename varchar(255) not null,
  approved bit default 0,
  id_approver mediumint references smf_members(id_member)
);

insert ignore into smf_bg2_banners (id, id_uploader, upload_time, filename, approved, id_approver)
values (
1,
1,
UNIX_TIMESTAMP(),
"http://badgame.net/header/headerimages/O6utm.jpg",
1,
1);

insert ignore into smf_bg2_banners (id, id_uploader, upload_time, filename, approved, id_approver)
values (
2,
1,
UNIX_TIMESTAMP(),
"http://badgame.net/header/headerimages/7r7w0.gif",
1,
1);

insert ignore into smf_bg2_banners (id, id_uploader, upload_time, filename, approved, id_approver)
values (
3,
1,
UNIX_TIMESTAMP(),
"http://badgame.net/header/headerimages/VUIZR.gif",
1,
1);
