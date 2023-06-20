<!--
extract RPC cumulo Prometheus
-->
<?php
//CONECT PROMETHEUS/CHAIN
error_reporting(0);

header('Content-Type: text/html; charset=utf-8');
//choose chain
switch($net=$_REQUEST['red']){
case $net=="circulus-1";
	$data = file_get_contents("http://74.208.16.201:26560");
	$ch="circulus-1";
break;
case $net=="";
	$data = file_get_contents("");
	$ch="";
break;
}

//data extract
switch($pide=$_REQUEST['dato']){
case $pide=="chain-id":
  echo $ch;
break;
case $pide=="num_tx":
  preg_match('|cometbft_consensus_total_txs{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $num_tx=$cap[1];	
  echo rtrim(number_format($num_tx,6),0);
break;
case $pide=="block":
  preg_match('|cometbft_consensus_height{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $bloquedato=$cap[1];
  echo rtrim(number_format($bloquedato,6),0);
break;
case $pide=="num_peers":
  preg_match('|cometbft_p2p_peers{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $sal=$cap[1];
  echo $sal;
break;
case $pide=="num_val":
  preg_match('|cometbft_consensus_validators{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $sal=$cap[1];
  echo $sal;
break;
case $pide=="block_size_b":
  preg_match('|cometbft_consensus_block_size_bytes{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $sal=round($cap[1]/1024,2);
  echo $sal;
break;
case $pide=="val_power":
  preg_match('|cometbft_consensus_validators_power{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $sal=$cap[1];
  echo rtrim(number_format($sal,6),0);
break;
case $pide=="missing_power":
  preg_match('|cometbft_consensus_missing_validators_power{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap ); 
  $sal=$cap[1];
  echo rtrim(number_format($sal,6),0);
break;
case $pide=="block_time":
  preg_match('|cometbft_consensus_block_interval_seconds_sum{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap );
  $sal=$cap[1];
  preg_match('|cometbft_consensus_block_interval_seconds_count{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap );
  $sal2=$cap[1];
  echo round($sal/$sal2,2);
break;
case $pide=="online_validators":
  preg_match('|cometbft_consensus_validators{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap );
  $sal=$cap[1];
  preg_match('|cometbft_consensus_missing_validators{chain_id="'.$ch.'"}(.*?)# HELP|is' , $data , $cap );
  $sal2=$cap[1];
  echo $sal-$sal2;
break;
}

?>
