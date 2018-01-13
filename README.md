# append_update MVC CodeIgniter

a php function in MVC CodeIgniter framework for transferring data from a temp database table to main table. the main table has restriction and the temp table has not any restriction. for some situation that data receive from unsafe & invalid source, or data has not valid values (for example: duplication of a unique value), this function can help. 

$step parameter is number of record you want to transfer in each transferring process.
for example: you have 3500 record on temp table that inserted by importing a unsafe xlsx file! if the step parameter be 1000, append_update function transfer data in 4 steps, three steps are with 1000 record and last step will be done with 500 record!
