document.querySelectorAll('.bar[data-h]').forEach(b=>requestAnimationFrame(()=>requestAnimationFrame(()=>b.style.height=b.dataset.h+'px')));
// Delete photo without reloading (falls back to normal form post if the API call fails).
document.addEventListener('click',async e=>{const b=e.target.closest('button[data-confirm]');if(!b)return;e.preventDefault();
 if(!confirm(b.dataset.confirm))return;const f=b.closest('form');
 if(b.value==='delete'){try{const r=await (await fetch('../api/delete-photo.php',{method:'POST',body:new FormData(f)})).json();if(r.ok){const c=b.closest('.col-6');c&&c.remove();return}}catch(_){}}
 const h=document.createElement('input');h.type='hidden';h.name='do';h.value=b.value;f.appendChild(h);f.submit();});
