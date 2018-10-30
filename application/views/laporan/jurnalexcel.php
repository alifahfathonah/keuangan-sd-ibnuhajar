<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=jurnal_".$date.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
				<table width="100%" border="1">
					<tr>
						<th scope="col" style="width:30px;vertical-align:top">No</th>
						<th scope="col" style="text-align:center;vertical-align:top">Tgl Transaksi</th>
						<th scope="col" style="text-align:center;vertical-align:top">Keterangan</th>
						<th scope="col" style="text-align:center;vertical-align:top">Nama Siswa (Kelas)</th>
						<th scope="col" style="text-align:right;vertical-align:top">Jumlah</th>
						<th scope="col" style="text-align:center;vertical-align:top">Catatan</th>

					</tr>
					<?
								$k=count($trr);
								$jlhhh=0;
								if($k!=0)
								{
									$no=1;
									foreach($trr as $i =>$v)
									{
										// if($v[0]->idjenis!=10 && $v[0]->keterangan!='7')
										// {
											echo '<tr>';
											echo '<td style="text-align:center;vertical-align:top">'.($no).'</td>';
											echo '<td style="text-align:center;vertical-align:top">'.(tgl_indo($v[0]->tgl_transaksi)).'</td>';
											echo '<td style="text-align:left;vertical-align:top">';
											$c=count($v);
											$jlh='';
											for($j=0;$j<$c;$j++)
											{
												if($v[$j]->keterangan!=7 || $v[$j]->idjenis!=10)
												{
													if($v[$j]->keterangan!=0)
														$bb=' -- Bulan : '.getBulan($v[$j]->keterangan).' '.$v[$j]->thn.'';
													else
														$bb=' '.$v[$j]->thn.'';
													
													echo $v[$j]->jenis.$bb.'<br>';
													$jlh.=($v[$j]->jumlah_2).'<br>';

													$jlhhh+=$v[$j]->jumlah_2;
												}
											}
											echo '</td>';
											echo '<td style="text-align:left;vertical-align:top">'.$v[0]->nama.' : Kelas '.$v[0]->t_kelas_id.'</td>';
											echo '<td style="text-align:right;vertical-align:top">'.$jlh.'</td>';
											echo '<td style="text-align:left;vertical-align:top">'.(strpos($v[0]->catatan,'idclub') !== false ? '-' : $v[0]->catatan).'</td>';
											echo '</tr>';
											$no++;
										// }
									}
								}
							?>

								<tr>
									<th style="text-align:right;vertical-align:top" colspan="4">Total Penerimaan Harian</th>
									<th style="text-align:right;vertical-align:top"><?=($jlhhh)?></th>
									<th style="text-align:right;vertical-align:top"></th>
								</tr>
				</table>