SELECT c.id, c.`text`, c.`timestamp`, u.`name` as username
FROM appstoredb.comments c
join appstoredb.users u on u.id = c.userid
WHERE c.projectid=1
