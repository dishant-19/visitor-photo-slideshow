const A=document.getElementById('a'),B=document.getElementById('b'),nm=document.getElementById('name'),em=document.getElementById('empty');
let photos=[],i=-1,dur=10,order='chronological',paused=false,timer,front=A,known='';
const shuffle=a=>{for(let k=a.length-1;k>0;k--){const j=Math.floor(Math.random()*(k+1));[a[k],a[j]]=[a[j],a[k]]}return a};
function show(n){if(!photos.length)return;i=(n+photos.length)%photos.length;const p=photos[i],back=front===A?B:A;
 back.onload=()=>{back.classList.remove('out');back.classList.add('on');front.classList.remove('on');front.classList.add('out');front=back;cap(p)};back.src='uploads/photos/'+encodeURIComponent(p.filename)}
function sched(){clearTimeout(timer);if(!paused)timer=setTimeout(()=>{show(i+1);sched()},dur*1000)}
async function load(){try{const r=await (await fetch('api/get-photos.php')).json();dur=r.duration;order=r.order;const sig=r.photos.map(p=>p.id).join();
 if(sig!==known){known=sig;const cur=photos[i]&&photos[i].id;photos=order==='random'?shuffle(r.photos):r.photos;const k=photos.findIndex(p=>p.id===cur);
  em.style.display=photos.length?'none':'grid';if(k>=0)i=k;else if(photos.length){show(0);sched()}else{i=-1;A.classList.remove('on');B.classList.remove('on');nm.textContent=''}}}catch(e){}}
document.getElementById('next').onclick=()=>{show(i+1);sched()};document.getElementById('prev').onclick=()=>{show(i-1);sched()};
document.getElementById('pp').onclick=e=>{paused=!paused;e.currentTarget.innerHTML=`<i class="fa-solid fa-${paused?'play':'pause'}"></i>`;sched()};
document.getElementById('fs').onclick=()=>document.fullscreenElement?document.exitFullscreen():document.documentElement.requestFullscreen();
document.onkeydown=e=>{if(e.key==='ArrowRight')next.click();if(e.key==='ArrowLeft')prev.click();if(e.key===' ')pp.click()};
const cap=p=>{const n=document.createElement('b'),d=document.createElement('small');n.textContent=p.name;d.textContent=new Date(p.created_at.replace(' ','T')).toLocaleDateString(undefined,{year:'numeric',month:'long',day:'numeric'});nm.replaceChildren(n,d)};
load();setInterval(load,30000);
