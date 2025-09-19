/* import React from 'react';
import { createRoot } from 'react-dom/client';
import "./frontend.scss";

console.log('Frontend.js file is loading!');

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, looking for divs...');
    
    const divsToUpdate = document.querySelectorAll(".wp-block-ourplugin-are-you-paying-attention.paying-attention-update-me");
    console.log('Found divs:', divsToUpdate.length);
    console.log('Divs found:', divsToUpdate);
    
    if (divsToUpdate.length === 0) {
        console.log('No divs found! Check if save function is working');
        return;
    }
    
    divsToUpdate.forEach(function(div, index) {
        console.log(`Processing div ${index + 1}:`, div);
        
        try {
            const root = createRoot(div);
            root.render(<SimpleTest />);
            div.classList.remove('paying-attention-update-me');
            console.log(`Successfully processed div ${index + 1}`);
        } catch (error) {
            console.error(`Error processing div ${index + 1}:`, error);
        }
    });
});

function SimpleTest() {
    console.log('SimpleTest component rendering');
    return (
        <div style={{ padding: '20px', border: '2px solid red', backgroundColor: '#ffeeee' }}>
            <h3 style={{ color: 'red' }}>🔥 FRONTEND.JS IS WORKING! 🔥</h3>
            <p>React replaced the original content!</p>
        </div>
    );
} */

import React from 'react';
import { createRoot } from 'react-dom/client';

// Functional component
function HelloComponent() {
    return <h2 style={{color: 'red'}}>Hello from React!!!!! 🎉</h2>;
}

document.addEventListener('DOMContentLoaded', function() {
    const divs = document.querySelectorAll(".paying-attention-update-me");
    
    divs.forEach(function(div) {
        const root = createRoot(div);
        root.render(<HelloComponent />);
        div.classList.remove('paying-attention-update-me');
    });
});