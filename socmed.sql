/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     07/11/2021 22:31:11                          */
/*==============================================================*/


drop table if exists LEVEL;

drop table if exists PERTEMANAN;

drop table if exists POSTING;

drop table if exists USER;

drop table if exists USER_PERTEMANAN;

drop table if exists USER_POSTING;

/*==============================================================*/
/* Table: LEVEL                                                 */
/*==============================================================*/
create table LEVEL
(
   IDLEVEL              varchar(5) not null,
   NAMALEVEL            varchar(10) not null,
   primary key (IDLEVEL)
);

/*==============================================================*/
/* Table: PERTEMANAN                                            */
/*==============================================================*/
create table PERTEMANAN
(
   IDPERTEMANAN         varchar(5) not null,
   STATUSPERTEMANAN     varchar(30) not null,
   primary key (IDPERTEMANAN)
);

/*==============================================================*/
/* Table: POSTING                                               */
/*==============================================================*/
create table POSTING
(
   IDPOSTING            varchar(5) not null,
   PESAN                text not null,
   GAMBARPOSTING        varchar(256) not null,
   primary key (IDPOSTING)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   IDUSER               varchar(5) not null,
   IDLEVEL              varchar(5),
   USERNAME             varchar(12) not null,
   PASSWORD             varchar(20) not null,
   NAMAUSER             varchar(256) not null,
   PHOTO                varchar(256) not null,
   EMAIL                varchar(256) not null,
   primary key (IDUSER)
);

/*==============================================================*/
/* Table: USER_PERTEMANAN                                       */
/*==============================================================*/
create table USER_PERTEMANAN
(
   IDUSER               varchar(5) not null,
   IDPERTEMANAN         varchar(5) not null,
   primary key (IDUSER, IDPERTEMANAN)
);

/*==============================================================*/
/* Table: USER_POSTING                                          */
/*==============================================================*/
create table USER_POSTING
(
   IDUSER               varchar(5) not null,
   IDPOSTING            varchar(5) not null,
   primary key (IDUSER, IDPOSTING)
);

alter table USER add constraint FK_USER_LEVEL foreign key (IDLEVEL)
      references LEVEL (IDLEVEL) on delete restrict on update cascade;

alter table USER_PERTEMANAN add constraint FK_USER_PERTEMANAN foreign key (IDUSER)
      references USER (IDUSER) on delete restrict on update cascade;

alter table USER_PERTEMANAN add constraint FK_USER_PERTEMANAN2 foreign key (IDPERTEMANAN)
      references PERTEMANAN (IDPERTEMANAN) on delete restrict on update cascade;

alter table USER_POSTING add constraint FK_USER_POSTING foreign key (IDUSER)
      references USER (IDUSER) on delete restrict on update cascade;

alter table USER_POSTING add constraint FK_USER_POSTING2 foreign key (IDPOSTING)
      references POSTING (IDPOSTING) on delete restrict on update cascade;

