document.addEventListener('DOMContentLoaded', function() {
    const templeGrid = document.querySelector('.temple-grid');
    const cards = document.querySelectorAll('.temple-card');
    const playPauseBtn = document.getElementById('playPauseBtn');
    let currentIndex = 0;
    let isPlaying = false;
    let slideInterval;
    
    function hideAllCards() {
        cards.forEach(card => {
            card.style.display = 'none';
        });
    }
    
    function showCard(index) {
        hideAllCards();
        cards[index].style.display = 'block';
    }
    
    function nextCard() {
        currentIndex = (currentIndex + 1) % cards.length;
        showCard(currentIndex);
    }
    
    function startSlideshow() {
        // แสดงรูปแรกก่อนเริ่ม slideshow
        currentIndex = 0;  // รีเซ็ต index เป็น 0
        hideAllCards();
        showCard(currentIndex);  // แสดงรูปแรก
        
        slideInterval = setInterval(nextCard, 2000);
        playPauseBtn.textContent = 'Pause';
        isPlaying = true;
        
        // เปลี่ยนเป็นแสดงทีละรูป
        templeGrid.classList.remove('grid-view');
        cards.forEach(card => {
            card.style.position = 'absolute';
        });
    }
    
    function stopSlideshow() {
        clearInterval(slideInterval);
        playPauseBtn.textContent = 'Play';
        isPlaying = false;
        
        // เปลี่ยนเป็นแสดง grid 4 คอลัมภ์
        templeGrid.classList.add('grid-view');
        cards.forEach(card => {
            card.style.display = 'block';
            card.style.position = 'relative';
        });
    }
    
    // ควบคุมการเล่น/หยุด
    playPauseBtn.addEventListener('click', function() {
        if (isPlaying) {
            stopSlideshow();
        } else {
            startSlideshow();
        }
    });
    
    // เริ่มต้น - แสดง grid view
    templeGrid.classList.add('grid-view');  // เพิ่มคลาส grid-view
    cards.forEach(card => {
        card.style.display = 'block';
        card.style.position = 'relative';
    });
    
    // ตั้งค่าสถานะเริ่มต้นเป็น pause
    isPlaying = false;
    playPauseBtn.textContent = 'Play';
});
