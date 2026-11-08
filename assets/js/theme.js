(function(){const KEY='vps-theme',root=document.documentElement,rm=matchMedia('(prefers-reduced-motion:reduce)').matches;
const cur=()=>root.getAttribute('data-bs-theme')==='light'?'light':'dark';
function apply(t,save){root.setAttribute('data-bs-theme',t);if(save)try{localStorage.setItem(KEY,t)}catch(e){}
 document.querySelectorAll('[data-theme-toggle]').forEach(b=>{b.setAttribute('aria-pressed',t==='light');b.setAttribute('aria-label',t==='dark'?'Switch to light mode':'Switch to dark mode')});
 dispatchEvent(new CustomEvent('themechange',{detail:t}))}
apply(cur(),false);
document.addEventListener('click',e=>{const b=e.target.closest('[data-theme-toggle]');if(!b)return;const next=cur()==='dark'?'light':'dark';
 if(!document.startViewTransition||rm){apply(next,true);return}
 const r=b.getBoundingClientRect(),x=r.left+r.width/2,y=r.top+r.height/2,R=Math.hypot(Math.max(x,innerWidth-x),Math.max(y,innerHeight-y));
 document.startViewTransition(()=>apply(next,true)).ready.then(()=>root.animate({clipPath:[`circle(0 at ${x}px ${y}px)`,`circle(${R}px at ${x}px ${y}px)`]},{duration:650,easing:'cubic-bezier(.4,0,.2,1)',pseudoElement:'::view-transition-new(root)'})).catch(()=>{})});
matchMedia('(prefers-color-scheme: light)').addEventListener('change',e=>{let s=null;try{s=localStorage.getItem(KEY)}catch(_){}if(!s)apply(e.matches?'light':'dark',false)});})();
