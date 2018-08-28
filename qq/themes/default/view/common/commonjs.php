<script>
	Array.prototype.getIndex=function(e){
		for(var i=0;i<this.length;i++){
			if(e==this[i]) return i;
		}
		return -1;
	}
</script>	