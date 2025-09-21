let scale = 1;
let posX = 0, posY = 0;
let isDragging = false;
let startX, startY;

const img = document.querySelector('#kaart img');
const container = document.querySelector('#kaart');

// =======================
// Desktop: mouse support
// =======================
container.addEventListener("wheel", (e) => {
  e.preventDefault();
  scale += e.deltaY * -0.001;
  scale = Math.min(Math.max(1, scale), 3);
  clampPosition();
  updateTransform();
}, { passive: false });

container.addEventListener("mousedown", (e) => {
  isDragging = true;
  startX = e.clientX - posX;
  startY = e.clientY - posY;
  container.classList.add("dragging");
});

container.addEventListener("mousemove", (e) => {
  if (!isDragging) return;
  posX = e.clientX - startX;
  posY = e.clientY - startY;
  clampPosition();
  updateTransform();
});

document.addEventListener("mouseup", () => {
  isDragging = false;
  container.classList.remove("dragging");
});

// =======================
// Mobile: touch support
// =======================
let lastTouchDist = null;

container.addEventListener("touchstart", (e) => {
  if (e.touches.length === 1) {
    // single finger drag
    isDragging = true;
    startX = e.touches[0].clientX - posX;
    startY = e.touches[0].clientY - posY;
  } else if (e.touches.length === 2) {
    // pinch start
    lastTouchDist = getTouchDist(e.touches);
  }
}, { passive: false });

container.addEventListener("touchmove", (e) => {
  e.preventDefault();

  if (e.touches.length === 1 && isDragging) {
    // dragging
    posX = e.touches[0].clientX - startX;
    posY = e.touches[0].clientY - startY;
    clampPosition();
    updateTransform();
  } else if (e.touches.length === 2) {
    // pinch zoom
    const dist = getTouchDist(e.touches);
    if (lastTouchDist) {
      const delta = dist - lastTouchDist;
      scale += delta * 0.005; // adjust zoom speed
      scale = Math.min(Math.max(1, scale), 3);
      clampPosition();
      updateTransform();
    }
    lastTouchDist = dist;
  }
}, { passive: false });

container.addEventListener("touchend", (e) => {
  if (e.touches.length < 2) {
    lastTouchDist = null;
  }
  if (e.touches.length === 0) {
    isDragging = false;
  }
});

// =======================
// Helpers
// =======================
function getTouchDist(touches) {
  const dx = touches[0].clientX - touches[1].clientX;
  const dy = touches[0].clientY - touches[1].clientY;
  return Math.sqrt(dx*dx + dy*dy);
}

function clampPosition() {
  const rect = container.getBoundingClientRect();
  const baseWidth = rect.width;
  const baseHeight = rect.height;

  const imgWidth = baseWidth * scale;
  const imgHeight = baseHeight * scale;

  const maxX = Math.max(0, (imgWidth - rect.width) / 2);
  const maxY = Math.max(0, (imgHeight - rect.height) / 2);

  posX = Math.min(Math.max(posX, -maxX), maxX);
  posY = Math.min(Math.max(posY, -maxY), maxY);
}

function updateTransform() {
  img.style.transform = `translate(calc(-50% + ${posX}px), calc(-50% + ${posY}px)) scale(${scale})`;
}