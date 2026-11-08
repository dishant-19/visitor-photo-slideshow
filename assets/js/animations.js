(function(){document.documentElement.classList.add('js');
const rm=matchMedia('(prefers-reduced-motion:reduce)').matches;
const io='IntersectionObserver'in window?new IntersectionObserver(es=>es.forEach(x=>{if(x.isIntersecting){const t=x.target;t.classList.add('in');setTimeout(()=>t.classList.add('done'),1200);io.unobserve(t)}}),{threshold:.1}):null;
document.querySelectorAll('.reveal').forEach((el,k)=>{el.style.setProperty('--d',(k%4)*90+'ms');io?io.observe(el):el.classList.add('in','done')});
document.querySelectorAll('.count').forEach(el=>{const n=+el.dataset.n;let i=0;const s=Math.max(1,Math.ceil(n/30));const id=setInterval(()=>{i=Math.min(n,i+s);el.textContent=i;if(i>=n)clearInterval(id)},25)});
// 3D tilt + glare on public cards (mouse devices only)
if(document.body.classList.contains('public')&&matchMedia('(hover:hover)').matches&&!rm)document.querySelectorAll('.reveal>.glass,.gcard').forEach(el=>{el.classList.add('tilt');let raf;
 el.addEventListener('pointermove',e=>{const r=el.getBoundingClientRect(),px=(e.clientX-r.left)/r.width,py=(e.clientY-r.top)/r.height;cancelAnimationFrame(raf);
  raf=requestAnimationFrame(()=>{el.style.setProperty('--rx',((.5-py)*9).toFixed(2)+'deg');el.style.setProperty('--ry',((px-.5)*11).toFixed(2)+'deg');el.style.setProperty('--gx',px*100+'%');el.style.setProperty('--gy',py*100+'%');el.classList.add('tilting')})});
 el.addEventListener('pointerleave',()=>{cancelAnimationFrame(raf);el.style.removeProperty('--rx');el.style.removeProperty('--ry');el.classList.remove('tilting')})});
})();
// 3D depth field: dust drifting toward the viewer, parallax on pointer + scroll
(function(){const c=document.getElementById('particles');if(!c||matchMedia('(prefers-reduced-motion:reduce)').matches)return;
const x=c.getContext('2d'),col=()=>getComputedStyle(document.documentElement).getPropertyValue('--particle').trim()||'212,175,55';
let w,h,dpr,rgb=col(),px=0,py=0,tx=0,ty=0,sc=0;
const rs=()=>{dpr=Math.min(devicePixelRatio||1,2);w=innerWidth;h=innerHeight;c.width=w*dpr;c.height=h*dpr;x.setTransform(dpr,0,0,dpr,0,0)};rs();
addEventListener('resize',rs);addEventListener('themechange',()=>rgb=col());
addEventListener('pointermove',e=>{tx=e.clientX/w-.5;ty=e.clientY/h-.5},{passive:true});addEventListener('scroll',()=>sc=scrollY,{passive:true});
const mk=z=>({x:(Math.random()-.5)*2.4,y:(Math.random()-.5)*2.4,z:z||Math.random()*.95+.05,r:Math.random()*1.6+.6});
const ps=Array.from({length:w<700?45:80},()=>mk());
(function f(){x.clearRect(0,0,w,h);px+=(tx-px)*.05;py+=(ty-py)*.05;const k=Math.min(w,h)*.45;
 ps.forEach(p=>{p.z-=.0009;const sx=w/2+(p.x-px*.6)*k/p.z,sy=h/2+(p.y-py*.6)*k/p.z-sc*(1-p.z)*.25;
  if(p.z<.05||sx<-40||sx>w+40||sy<-40||sy>h+40){Object.assign(p,mk(1));return}
  x.beginPath();x.arc(sx,sy,Math.min(7,p.r*Math.pow(1/p.z,.7)),0,6.283);x.fillStyle='rgba('+rgb+','+Math.min(.7,(1-p.z)*1.1+.08).toFixed(2)+')';x.fill()});
 requestAnimationFrame(f)})();})();
