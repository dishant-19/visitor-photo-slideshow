const drop=document.getElementById('drop'),inp=document.getElementById('files'),pv=document.getElementById('previews'),go=document.getElementById('go'),msg=document.getElementById('msg'),bar=document.getElementById('bar');
let list=[];const OK=['image/jpeg','image/png','image/webp'];
const alertMsg=(t,c)=>msg.innerHTML=`<div class="alert alert-${c}"></div>`,show=(t,c)=>{alertMsg();msg.firstChild.textContent=t;msg.firstChild.className='alert alert-'+c};
function add(fs){for(const f of fs){if(!OK.includes(f.type)){show(f.name+': only JPG, PNG or WebP allowed.','danger');continue}
 if(f.size>5*1024*1024){show(f.name+': larger than 5 MB.','danger');continue}list.push(f)}render()}
function render(){pv.innerHTML='';list.forEach((f,i)=>{const d=document.createElement('div');d.className='col-4 col-md-3 thumb';d.innerHTML='<img><button class="btn btn-sm btn-danger" type="button">&times;</button>';d.querySelector('img').src=URL.createObjectURL(f);d.querySelector('button').onclick=()=>{list.splice(i,1);render()};pv.appendChild(d)});go.disabled=!list.length}
drop.onclick=()=>inp.click();inp.onchange=()=>{add(inp.files);inp.value=''};
['dragover','dragenter'].forEach(e=>drop.addEventListener(e,x=>{x.preventDefault();drop.classList.add('over')}));
['dragleave','drop'].forEach(e=>drop.addEventListener(e,x=>{x.preventDefault();drop.classList.remove('over')}));
drop.addEventListener('drop',x=>add(x.dataTransfer.files));
go.onclick=()=>{const fd=new FormData();fd.append('csrf',CSRF);fd.append('category',document.getElementById('cat').value);list.forEach(f=>fd.append('photos[]',f));
 const x=new XMLHttpRequest();x.open('POST','api/upload-photo.php');bar.parentElement.classList.remove('d-none');go.disabled=true;
 x.upload.onprogress=e=>{if(e.lengthComputable)bar.style.width=(e.loaded/e.total*100)+'%'};
 x.onload=()=>{let r={};try{r=JSON.parse(x.responseText)}catch(_){}if(x.status===200&&r.ok)location='success.php';else{show(r.message||'Upload failed.','danger');go.disabled=false;bar.parentElement.classList.add('d-none')}};
 x.onerror=()=>{show('Network error.','danger');go.disabled=false};x.send(fd)};
