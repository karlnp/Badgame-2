-- banners
create table if not exists smf_bg2_banners (
  id mediumint primary key auto_increment,
  id_uploader mediumint not null references smf_members(id_member),
  upload_time int(10) not null,
  filename varchar(255) not null,
  hash varchar(255) not null,
  approved bit default 0,
  id_approver mediumint references smf_members(id_member)
);
