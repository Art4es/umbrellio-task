select min(id) as min_id, group_id, count(id) as count from (
    select prev.*, sum(difference) over (order by prev.id) as my_rank from (
         select id, group_id, case when (group_id - coalesce(lag(group_id) over (order by id), group_id)) = 0 then 0 else 1 END as difference                                                                         from users
    ) prev
) with_rk
group by group_id, my_rank order by min_id;