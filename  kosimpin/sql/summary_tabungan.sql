drop view summary_tabungan;

create view summary_tabungan as 
select sum(jumlah_in) as 'j_in',sum(jumlah_out) as 'j_out',sum(jumlah_in-jumlah_out) as 'saldo',
tabungan.id_anggota,anggota.nama,tabungan.id_jenis_tabungan
from tabungan
inner join anggota on tabungan.id_anggota = anggota.id
inner join jenis_tabungan on tabungan.id_jenis_tabungan = jenis_tabungan.id
group by anggota.id,tabungan.id_jenis_tabungan order by anggota.nama;