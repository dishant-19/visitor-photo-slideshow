(function(){
const ld=document.getElementById('loader'),hide=()=>ld&&ld.classList.add('hide');addEventListener('load',()=>setTimeout(hide,300));setTimeout(hide,3000);
document.querySelectorAll('.alert-auto').forEach(a=>setTimeout(()=>{a.style.transition='opacity .6s';a.style.opacity=0;setTimeout(()=>a.remove(),600)},6000));
const rf=document.getElementById('register-form');
if(rf)rf.addEventListener('submit',async e=>{e.preventDefault();const box=document.getElementById('reg-errors'),btn=rf.querySelector('button');btn.disabled=true;
 try{const r=await (await fetch('api/register.php',{method:'POST',body:new FormData(rf)})).json();
  if(r.ok){location=r.redirect;return}
  box.innerHTML='';(r.errors||[r.message||'Registration failed.']).forEach(m=>{const d=document.createElement('div');d.className='alert alert-danger';d.textContent=m;box.appendChild(d)});btn.disabled=false;
 }catch(_){rf.submit()}});
// Home hero: ambient cross-fade + 3D ring of approved photos (drag to spin)
const hero=document.getElementById('hero');
if(hero)fetch('api/get-photos.php').then(r=>r.json()).then(d=>{const ps=d.photos.slice(-8),L=[...hero.querySelectorAll('.hero-bg')],url=p=>"url('uploads/photos/"+encodeURIComponent(p.filename)+"')";
 if(ps.length){L[0].style.backgroundImage=url(ps[0]);if(ps.length>1){let t=0,i=0;setInterval(()=>{i=(i+1)%ps.length;t^=1;L[t].style.backgroundImage=url(ps[i]);L[t].classList.remove('on');void L[t].offsetWidth;L[t].classList.add('on');L[t^1].classList.remove('on')},5000)}}
 const ring=document.getElementById('ring'),stage=document.getElementById('stage');if(!ring||!stage)return;
 const rm=matchMedia('(prefers-reduced-motion:reduce)').matches,imgs=ps.length?ps.map(url):["url('assets/images/background.jpg')"],n=Math.min(10,Math.max(7,imgs.length)),step=360/n;
 const w=stage.clientWidth<440?112:156,R=Math.round(w/2/Math.tan(Math.PI/n)+16);ring.style.setProperty('--w',w+'px');ring.style.setProperty('--h',Math.round(w*1.3)+'px');
 const faces=Array.from({length:n},(_,i)=>{const f=document.createElement('div');f.className='face';f.style.backgroundImage=imgs[i%imgs.length];f.style.backgroundPosition=(imgs.length<n?(i*37)%100:50)+'% 50%';f.style.transform='rotateY('+i*step+'deg) translateZ('+R+'px)';ring.appendChild(f);return f});
 let a=0,v=rm?0:9,drag=false,lx=0,ty=0,rx=0;const base=rm?0:.14;
 stage.addEventListener('pointerdown',e=>{drag=true;lx=e.clientX;stage.setPointerCapture(e.pointerId);stage.style.cursor='grabbing'});
 stage.addEventListener('pointermove',e=>{const r=stage.getBoundingClientRect();ty=-((e.clientY-r.top)/r.height-.5)*14;if(drag){v=(e.clientX-lx)*.32;lx=e.clientX}});
 ['pointerup','pointercancel'].forEach(t=>stage.addEventListener(t,()=>{drag=false;stage.style.cursor=''}));
 (function f(){if(!drag)v+=(base-v)*.035;a+=v;rx+=(ty-rx)*.06;ring.style.transform='rotateX('+rx.toFixed(2)+'deg) rotateY('+a.toFixed(2)+'deg)';
  faces.forEach((el,i)=>{el.style.filter='brightness('+(.5+(Math.cos((a+i*step)*Math.PI/180)+1)/4).toFixed(2)+')'});requestAnimationFrame(f)})();
}).catch(()=>{});
// Gallery full-screen preview
const pv=document.getElementById('pv');
if(pv&&window.bootstrap){const m=new bootstrap.Modal(pv);document.querySelectorAll('.gcard img').forEach(i=>i.addEventListener('click',()=>{document.getElementById('pvimg').src=i.dataset.full;document.getElementById('pvcap').textContent=i.dataset.cap;m.show()}))}
})();
