function vote ($i) {
	var een = document.getElementById("1");
	var twee = document.getElementById("2");
	var drie = document.getElementById("3");
	var vier = document.getElementById("4");
	var vijf = document.getElementById("5");
	if( $i == 1) {
		een.innerHTML = '<img onMouseOver="vote(1);" src="images/ster.gif" />';
		twee.innerHTML = '<img onMouseOver="vote(2);" src="images/ster_off.gif" />';
		drie.innerHTML = '<img onMouseOver="vote(3);" src="images/ster_off.gif" />';
		vier.innerHTML = '<img onMouseOver="vote(4);" src="images/ster_off.gif" />';
		vijf.innerHTML = '<img onMouseOver="vote(5);" src="images/ster_off.gif" />';
	}
	if( $i == 2) {
		een.innerHTML = '<img onMouseOver="vote(1);" src="images/ster.gif" />';
		twee.innerHTML = '<img onMouseOver="vote(2);" src="images/ster.gif" />';
		drie.innerHTML = '<img onMouseOver="vote(3);" src="images/ster_off.gif" />';
		vier.innerHTML = '<img onMouseOver="vote(4);" src="images/ster_off.gif" />';
		vijf.innerHTML = '<img onMouseOver="vote(5);" src="images/ster_off.gif" />';
	}
	if( $i == 3) {
		een.innerHTML = '<img onMouseOver="vote(1);" src="images/ster.gif" />';
		twee.innerHTML = '<img onMouseOver="vote(2);" src="images/ster.gif" />';
		drie.innerHTML = '<img onMouseOver="vote(3);" src="images/ster.gif" />';
		vier.innerHTML = '<img onMouseOver="vote(4);" src="images/ster_off.gif" />';
		vijf.innerHTML = '<img onMouseOver="vote(5);" src="images/ster_off.gif" />';
	}
	if( $i == 4) {
		een.innerHTML = '<img onMouseOver="vote(1);" src="images/ster.gif" />';
		twee.innerHTML = '<img onMouseOver="vote(2);" src="images/ster.gif" />';
		drie.innerHTML = '<img onMouseOver="vote(3);" src="images/ster.gif" />';
		vier.innerHTML = '<img onMouseOver="vote(4);" src="images/ster.gif" />';
		vijf.innerHTML = '<img onMouseOver="vote(5);" src="images/ster_off.gif" />';
	}
	if( $i == 5) {
		een.innerHTML = '<img onMouseOver="vote(1);" src="images/ster.gif" />';
		twee.innerHTML = '<img onMouseOver="vote(2);" src="images/ster.gif" />';
		drie.innerHTML = '<img onMouseOver="vote(3);" src="images/ster.gif" />';
		vier.innerHTML = '<img onMouseOver="vote(4);" src="images/ster.gif" />';
		vijf.innerHTML = '<img onMouseOver="vote(5);" src="images/ster.gif" />';
	}
}

function klikken ($id,$a) {
	window.location.href = "?p=youtubevote&id=" + $id + "&a=" + $a + "&s=vote";
}