INSERT INTO `md_profile` (
`id` ,
`name` ,
`object_class_name` ,
`created_at` ,
`updated_at`
)
VALUES (
NULL , 'categorias', 'mdCategory', '2012-12-14 00:00:00', '2012-12-14 00:00:00'
);

INSERT INTO `md_profile_attribute` (
`md_attribute_id` ,
`md_profile_id`
)
VALUES (
'1', '4'
);
