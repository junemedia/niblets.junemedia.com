<?php

$sOutPut = '';

if (trim($_GET['iCampusId']) == 1364) {
	$aArray = array('08001','08002','08003','08004','08007','08009','08010','08012','08014','08018','08020','08021',
	'08023','08025','08026','08027','08028','08029','08030','08031','08032','08033','08034','08035','08038','08039',
	'08043','08045','08046','08049','08051','08052','08053','08054','08055','08056','08057','08059','08061','08062',
	'08063','08065','08066','08067','08069','08070','08071','08072','08073','08074','08075','08076','08077','08078',
	'08079','08080','08081','08083','08084','08085','08086','08089','08090','08091','08093','08094','08095','08096',
	'08097','08098','08099','08101','08102','08103','08104','08105','08106','08107','08108','08109','08110','08302',
	'08310','08311','08312','08313','08318','08320','08322','08323','08326','08327','08328','08332','08341','08343',
	'08344','08345','08346','08347','08350','08352','08353','08360','08361','08362','17503','17506','17507','17509',
	'17518','17519','17527','17528','17529','17534','17535','17536','17555','17557','17560','17562','17563','17566',
	'17568','17572','17573','17579','17581','18074','18084','18915','18924','18932','18936','18957','18958','18964',
	'18974','18976','18979','19001','19002','19003','19004','19006','19008','19009','19010','19012','19013','19014',
	'19015','19016','19017','19018','19019','19020','19022','19023','19025','19026','19027','19028','19029','19031',
	'19032','19033','19034','19035','19036','19037','19038','19039','19040','19041','19043','19044','19046','19050',
	'19052','19053','19061','19063','19064','19065','19066','19070','19072','19073','19074','19075','19076','19078',
	'19079','19080','19081','19082','19083','19085','19086','19087','19088','19089','19090','19091','19092','19093',
	'19094','19095','19096','19098','19099','19101','19102','19103','19104','19105','19106','19107','19108','19109',
	'19110','19111','19112','19113','19114','19115','19116','19118','19119','19120','19121','19122','19123','19124',
	'19125','19126','19127','19128','19129','19130','19131','19132','19133','19134','19135','19136','19137','19138',
	'19139','19140','19141','19142','19143','19144','19145','19146','19147','19148','19149','19150','19151','19152',
	'19153','19154','19155','19160','19161','19162','19170','19171','19172','19173','19175','19176','19177','19178',
	'19179','19181','19182','19183','19184','19185','19187','19188','19191','19192','19193','19194','19195','19196',
	'19197','19244','19255','19301','19310','19311','19312','19316','19317','19318','19319','19320','19330','19331',
	'19333','19335','19339','19340','19341','19342','19343','19344','19345','19346','19347','19348','19350','19351',
	'19352','19353','19354','19355','19357','19358','19360','19362','19363','19365','19366','19367','19369','19371',
	'19372','19373','19374','19375','19376','19380','19381','19382','19383','19390','19395','19397','19398','19399',
	'19401','19403','19404','19405','19406','19407','19408','19409','19415','19420','19421','19422','19423','19424',
	'19425','19426','19428','19429','19430','19432','19435','19436','19437','19438','19440','19441','19442','19443',
	'19444','19446','19450','19451','19453','19454','19455','19456','19457','19460','19462','19464','19465','19468',
	'19470','19473','19474','19475','19477','19478','19480','19481','19482','19483','19484','19485','19486','19487',
	'19488','19489','19490','19492','19493','19494','19495','19496','19508','19518','19520','19523','19525','19542',
	'19543','19548','19701','19702','19703','19706','19707','19708','19709','19710','19711','19712','19713','19714',
	'19715','19716','19717','19718','19720','19721','19725','19726','19730','19731','19732','19733','19734','19735',
	'19736','19801','19802','19803','19804','19805','19806','19807','19808','19809','19810','19850','19880','19884',
	'19885','19886','19887','19889','19890','19891','19892','19893','19894','19895','19896','19897','19898','19899',
	'19901','19903','19904','19934','19936','19938','19955','19962','19977','21001','21005','21034','21078','21610',
	'21635','21645','21650','21651','21901','21902','21903','21904','21911','21912','21913','21914','21915','21916',
	'21917','21918','21919','21920','21921','21922','21930');
	
	if (!(in_array(trim($_GET['sZip']), $aArray))) {
	   $sOutPut = "Wilmington, DE campus is not within your zip code range.  Please select another campus for 'The National Massage Therapy Institute (NMTI)' offer.";
	}
}



if (trim($_GET['iCampusId']) == 1363) {
	$aArray = array('08001','08002','08003','08004','08007','08009','08010','08011','08012','08014','08015','08016',
	'08018','08019','08020','08021','08022','08023','08025','08026','08027','08028','08029','08030','08031','08032',
	'08033','08034','08035','08036','08037','08038','08039','08041','08042','08043','08045','08046','08048','08049',
	'08051','08052','08053','08054','08055','08056','08057','08059','08060','08061','08062','08063','08064','08065',
	'08066','08067','08068','08069','08070','08071','08072','08073','08074','08075','08076','08077','08078','08079',
	'08080','08081','08083','08084','08085','08086','08087','08088','08089','08090','08091','08093','08094','08095',
	'08096','08097','08098','08099','08101','08102','08103','08104','08105','08106','08107','08108','08109','08110',
	'08201','08205','08213','08215','08217','08220','08221','08224','08225','08231','08232','08234','08240','08241',
	'08250','08270','08302','08310','08311','08312','08313','08315','08316','08317','08318','08319','08320','08321',
	'08322','08323','08324','08326','08327','08328','08329','08330','08332','08340','08341','08342','08343','08344',
	'08345','08346','08347','08348','08349','08350','08352','08353','08360','08361','08362','08501','08505','08511',
	'08515','08518','08526','08533','08554','08560','08561','08562','08601','08602','08603','08604','08605','08606',
	'08607','08608','08609','08610','08611','08618','08619','08620','08625','08628','08629','08638','08640','08641',
	'08645','08646','08647','08648','08650','08666','08677','08690','08691','08695','08759','18901','18912','18914',
	'18915','18916','18922','18923','18924','18925','18927','18928','18929','18931','18932','18934','18936','18938',
	'18940','18943','18946','18954','18956','18964','18966','18974','18976','18977','18980','18991','19001','19002',
	'19003','19004','19006','19007','19008','19009','19010','19012','19013','19014','19015','19016','19017','19018',
	'19019','19020','19021','19022','19023','19025','19026','19027','19028','19029','19030','19031','19032','19033',
	'19034','19035','19036','19037','19038','19039','19040','19041','19043','19044','19046','19047','19048','19049',
	'19050','19052','19053','19054','19055','19056','19057','19058','19059','19061','19063','19064','19065','19066',
	'19067','19070','19072','19073','19074','19075','19076','19078','19079','19080','19081','19082','19083','19085',
	'19086','19087','19088','19089','19090','19091','19092','19093','19094','19095','19096','19098','19099','19101',
	'19102','19103','19104','19105','19106','19107','19108','19109','19110','19111','19112','19113','19114','19115',
	'19116','19118','19119','19120','19121','19122','19123','19124','19125','19126','19127','19128','19129','19130',
	'19131','19132','19133','19134','19135','19136','19137','19138','19139','19140','19141','19142','19143','19144',
	'19145','19146','19147','19148','19149','19150','19151','19152','19153','19154','19155','19160','19161','19162',
	'19170','19171','19172','19173','19175','19176','19177','19178','19179','19181','19182','19183','19184','19185',
	'19187','19188','19191','19192','19193','19194','19195','19196','19197','19244','19255','19301','19311','19312',
	'19317','19319','19331','19333','19335','19339','19340','19341','19342','19345','19347','19348','19350','19353',
	'19355','19357','19366','19372','19373','19374','19375','19380','19381','19382','19383','19395','19397','19398',
	'19399','19401','19403','19404','19405','19406','19407','19408','19409','19415','19420','19421','19422','19423',
	'19424','19425','19426','19428','19429','19430','19432','19436','19437','19438','19440','19441','19442','19443',
	'19444','19446','19450','19451','19453','19454','19455','19456','19460','19462','19468','19473','19474','19475',
	'19477','19480','19481','19482','19483','19484','19485','19486','19487','19488','19489','19490','19493','19494',
	'19495','19496','19701','19702','19703','19706','19707','19708','19709','19710','19711','19712','19713','19714',
	'19715','19716','19717','19718','19720','19721','19725','19726','19730','19731','19732','19733','19735','19736',
	'19801','19802','19803','19804','19805','19806','19807','19808','19809','19810','19850','19880','19884','19885',
	'19886','19887','19889','19890','19891','19892','19893','19894','19895','19896','19897','19898','19899');
	
	if (!(in_array(trim($_GET['sZip']), $aArray))) {
	   $sOutPut = "Turnersville, NJ campus is not within your zip code range.  Please select another campus for 'The National Massage Therapy Institute (NMTI)' offer.";
	}
}



if (trim($_GET['iCampusId']) == 1362) {
	$aArray = array('08003','08004','08005','08006','08008','08009','08011','08012','08015','08018','08019','08021',
	'08025','08026','08028','08029','08032','08037','08043','08045','08048','08049','08050','08053','08055','08064',
	'08068','08071','08074','08080','08081','08083','08084','08087','08088','08089','08091','08092','08094','08095',
	'08201','08202','08203','08204','08205','08210','08212','08213','08214','08215','08217','08218','08219','08220',
	'08221','08223','08224','08225','08226','08230','08231','08232','08234','08240','08241','08242','08243','08244',
	'08245','08246','08247','08248','08250','08251','08252','08260','08270','08302','08310','08311','08312','08313',
	'08314','08315','08316','08317','08318','08319','08320','08321','08322','08324','08326','08327','08328','08329',
	'08330','08332','08340','08341','08342','08343','08344','08345','08346','08347','08348','08349','08350','08352',
	'08353','08360','08361','08362','08401','08402','08403','08404','08405','08406','08731','08734','08758','08759');
	
	if (!(in_array(trim($_GET['sZip']), $aArray))) {
	   $sOutPut = "Egg Harbor/Atlantic City, NJ campus is not within your zip code range.  Please select another campus for 'The National Massage Therapy Institute (NMTI)' offer.";
	}
}


if (trim($_GET['iCampusId']) == 1361) {
	$aArray = array('08002','08003','08007','08010','08011','08016','08022','08029','08030','08031','08033','08034',
	'08035','08036','08041','08042','08043','08045','08046','08048','08049','08052','08053','08054','08057','08059',
	'08060','08063','08065','08073','08075','08076','08077','08078','08083','08093','08099','08101','08102','08103',
	'08104','08105','08106','08107','08108','08109','08110','08505','08515','08518','08530','08534','08554','08560',
	'08601','08603','08604','08605','08607','08608','08609','08610','08611','08618','08619','08620','08625','08628',
	'08629','08638','08645','08646','08647','08648','08666','08677','08695','18901','18912','18913','18914','18915',
	'18916','18917','18922','18923','18925','18926','18927','18928','18929','18931','18932','18933','18934','18936',
	'18938','18940','18943','18946','18949','18954','18956','18963','18966','18974','18976','18977','18980','18991',
	'19001','19002','19003','19004','19006','19007','19009','19010','19012','19019','19020','19021','19023','19025',
	'19026','19027','19030','19031','19034','19035','19038','19040','19041','19044','19046','19047','19048','19049',
	'19050','19053','19054','19055','19056','19057','19058','19059','19066','19067','19072','19075','19082','19083',
	'19085','19088','19090','19092','19093','19095','19096','19099','19101','19102','19103','19104','19105','19106',
	'19107','19108','19109','19110','19111','19112','19114','19115','19116','19118','19119','19120','19121','19122',
	'19123','19124','19125','19126','19127','19128','19129','19130','19131','19132','19133','19134','19135','19136',
	'19137','19138','19139','19140','19141','19142','19143','19144','19145','19146','19147','19148','19149','19150',
	'19151','19152','19153','19154','19155','19160','19161','19162','19170','19171','19172','19173','19175','19176',
	'19177','19178','19179','19181','19182','19183','19184','19185','19187','19188','19191','19192','19193','19194',
	'19195','19196','19197','19244','19255','19401','19403','19404','19405','19406','19409','19422','19424','19428',
	'19429','19436','19437','19440','19443','19444','19446','19454','19455','19462','19477','19486','19487','19488',
	'19489','19490');
	
	if (!(in_array(trim($_GET['sZip']), $aArray))) {
	   $sOutPut = "Philadelphia, PA campus is not within your zip code range.  Please select another campus for 'The National Massage Therapy Institute (NMTI)' offer.";
	}
}


if (trim($_GET['iCampusId']) == 1360) {
	$aArray = array('20001','20002','20003','20004','20005','20006','20007','20008','20009','20010','20011','20012',
	'20013','20015','20016','20017','20018','20019','20020','20022','20023','20024','20026','20027','20029','20030',
	'20032','20033','20035','20036','20037','20038','20039','20040','20041','20042','20043','20044','20045','20046',
	'20047','20049','20050','20051','20052','20053','20055','20056','20057','20058','20059','20060','20061','20062',
	'20063','20064','20065','20066','20067','20068','20069','20070','20071','20073','20074','20075','20076','20077',
	'20078','20080','20081','20082','20088','20090','20091','20097','20098','20099','20101','20102','20103','20104',
	'20105','20106','20107','20108','20109','20110','20111','20112','20113','20115','20116','20117','20118','20119',
	'20120','20121','20122','20124','20128','20129','20130','20131','20132','20134','20135','20136','20137','20138',
	'20139','20140','20141','20142','20143','20144','20146','20147','20148','20149','20151','20152','20153','20155',
	'20156','20158','20159','20160','20163','20164','20165','20166','20167','20168','20169','20170','20171','20172',
	'20175','20176','20177','20178','20180','20181','20182','20184','20185','20186','20187','20188','20189','20190',
	'20191','20192','20193','20194','20195','20196','20197','20198','20199','20201','20202','20203','20204','20206',
	'20207','20208','20210','20211','20212','20213','20214','20215','20216','20217','20218','20219','20220','20221',
	'20222','20223','20224','20226','20227','20228','20229','20230','20231','20232','20233','20235','20237','20238',
	'20239','20240','20241','20242','20244','20245','20250','20251','20254','20260','20261','20262','20265','20266',
	'20268','20270','20277','20289','20299','20301','20303','20306','20307','20310','20314','20315','20317','20318',
	'20319','20330','20337','20338','20340','20350','20355','20370','20372','20373','20374','20375','20376','20380',
	'20388','20389','20390','20391','20392','20393','20394','20395','20398','20401','20402','20403','20404','20405',
	'20406','20407','20408','20409','20410','20411','20412','20413','20414','20415','20416','20418','20419','20420',
	'20421','20422','20423','20424','20425','20426','20427','20428','20429','20431','20433','20434','20435','20436',
	'20437','20439','20440','20441','20442','20444','20447','20451','20453','20456','20460','20463','20468','20469',
	'20470','20472','20500','20501','20502','20503','20504','20505','20506','20507','20508','20509','20510','20511',
	'20515','20520','20521','20522','20523','20524','20525','20526','20527','20528','20529','20530','20531','20532',
	'20533','20534','20535','20536','20537','20538','20539','20540','20541','20542','20543','20544','20546','20547',
	'20548','20549','20550','20551','20552','20553','20554','20555','20557','20558','20559','20560','20565','20566',
	'20570','20571','20572','20573','20575','20576','20577','20578','20579','20580','20581','20585','20586','20590',
	'20591','20593','20594','20597','20599','20601','20602','20603','20604','20607','20608','20609','20610','20611',
	'20612','20613','20615','20616','20617','20618','20621','20622','20623','20624','20625','20627','20632','20635',
	'20636','20637','20639','20640','20643','20645','20646','20650','20656','20658','20659','20660','20661','20662',
	'20664','20675','20676','20677','20678','20682','20685','20689','20693','20695','20697','20701','20703','20704',
	'20705','20706','20707','20708','20709','20710','20711','20712','20714','20715','20716','20717','20718','20719',
	'20720','20721','20722','20723','20724','20725','20726','20731','20732','20733','20735','20736','20737','20738',
	'20740','20741','20742','20743','20744','20745','20746','20747','20748','20749','20750','20751','20752','20753',
	'20754','20755','20757','20758','20759','20762','20763','20764','20765','20768','20769','20770','20771','20772',
	'20773','20774','20775','20776','20777','20778','20779','20781','20782','20783','20784','20785','20787','20788',
	'20790','20791','20792','20794','20797','20799','20810','20811','20812','20813','20814','20815','20816','20817',
	'20818','20824','20825','20827','20830','20832','20833','20837','20838','20839','20841','20842','20847','20848',
	'20849','20850','20851','20852','20853','20854','20855','20857','20859','20860','20861','20862','20866','20868',
	'20871','20872','20874','20875','20876','20877','20878','20879','20880','20882','20883','20884','20885','20886',
	'20889','20891','20892','20894','20895','20896','20897','20898','20899','20901','20902','20903','20904','20905',
	'20906','20907','20908','20910','20911','20912','20913','20914','20915','20916','20918','20993','20997','21012',
	'21020','21022','21029','21032','21035','21036','21037','21041','21042','21043','21044','21045','21046','21048',
	'21052','21054','21056','21060','21061','21062','21071','21075','21076','21077','21090','21093','21094','21098',
	'21104','21106','21108','21113','21114','21117','21122','21123','21133','21136','21139','21140','21144','21146',
	'21150','21153','21157','21163','21201','21202','21203','21204','21205','21206','21207','21208','21209','21210',
	'21211','21212','21213','21214','21215','21216','21217','21218','21219','21221','21222','21223','21224','21225',
	'21226','21227','21228','21229','21230','21231','21233','21234','21235','21237','21239','21240','21241','21244',
	'21250','21251','21252','21263','21264','21265','21268','21270','21273','21274','21275','21278','21279','21280',
	'21281','21282','21283','21284','21285','21286','21287','21288','21289','21290','21297','21298','21401','21402',
	'21403','21404','21405','21409','21411','21412','21612','21619','21624','21647','21652','21665','21666','21671',
	'21676','21701','21702','21703','21704','21705','21709','21710','21714','21715','21716','21717','21718','21723',
	'21737','21738','21754','21755','21756','21757','21758','21759','21762','21765','21769','21770','21771','21773',
	'21774','21775','21776','21777','21779','21782','21784','21790','21791','21792','21793','21794','21797','21798',
	'22003','22009','22015','22025','22026','22027','22030','22031','22032','22033','22034','22035','22036','22037',
	'22038','22039','22040','22041','22042','22043','22044','22046','22047','22060','22066','22067','22079','22081',
	'22082','22092','22093','22095','22096','22101','22102','22103','22106','22107','22108','22109','22116','22118',
	'22119','22120','22121','22122','22124','22125','22134','22135','22150','22151','22152','22153','22156','22158',
	'22159','22160','22161','22172','22180','22181','22182','22183','22184','22185','22191','22192','22193','22194',
	'22195','22199','22201','22202','22203','22204','22205','22206','22207','22209','22210','22211','22212','22213',
	'22214','22215','22216','22217','22218','22219','22222','22223','22225','22226','22227','22229','22230','22234',
	'22240','22241','22242','22243','22244','22245','22246','22301','22302','22303','22304','22305','22306','22307',
	'22308','22309','22310','22311','22312','22313','22314','22315','22320','22321','22331','22332','22333','22334',
	'22336','22401','22402','22403','22404','22405','22406','22407','22408','22412','22430','22443','22446','22448',
	'22451','22463','22471','22481','22485','22526','22535','22544','22545','22547','22554','22555','22556','22611',
	'22620','22627','22639','22642','22643','22646','22712','22714','22718','22720','22724','22726','22728','22734',
	'22736','22737','22739','22741','22742','22746','25410','25414','25423','25425','25432','25438','25441','25442',
	'25446','56901','56915','56920','56944');
	
	if (!(in_array(trim($_GET['sZip']), $aArray))) {
	   $sOutPut = "Falls Church, VA campus is not within your zip code range.  Please select another campus for 'The National Massage Therapy Institute (NMTI)' offer.";
	}
}


unset($aArray);
echo $sOutPut;


?>
