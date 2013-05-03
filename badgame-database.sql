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

-- cache field (May need to run script with --force so this doesn't stop execution from progressing)
ALTER TABLE smf_messages ADD parsed_body TEXT NOT NULL;

-- Clear out cache field
UPDATE smf_messages set parsed_body = '';

-- last modified field on members
ALTER TABLE smf_members ADD last_modified int(10);

-- last read
create table if not exists smf_bg2_lastread (
  id_member mediumint not null references smf_members(id_member),
  id_thread mediumint not null references smf_topics(ID_TOPIC),
  postsread int(10),
  lastpostid int(10),
  primary key (id_member, id_thread)
);

-- add hidden column to banners
ALTER TABLE smf_bg2_banners ADD hidden bit default 0;

-- may 03 2013

-- add hidden threads table
create table if not exists smf_bg2_hiddenthreads (
  id_member mediumint not null references smf_members(id_member),
  id_thread mediumint not null references smf_topics(ID_TOPIC),
  primary key (id_member, id_thread)
);