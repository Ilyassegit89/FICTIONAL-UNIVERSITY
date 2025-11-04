

import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import './index.scss'

document.addEventListener('DOMContentLoaded', function() {
    const divs = document.querySelectorAll(".featured-professor-plugin");
    console.log("Processing frontEnd.js for featured plugin")

    divs.forEach(function(div) {
       
        // Parse the JSON inside the div
        const data = JSON.parse(div.textContent);
        // Log just the question string
        console.log(data);
        const root = createRoot(div);
        root.render(<HelloComponent {...data} />);
        //div.classList.remove('paying-attention-update-me');
    });
});

function HelloComponent(props) {
    return(
        <div class="professor-callout" id={props.profId}>
            <div class="professor-callout__photo"></div>
            <div class="professor-callout__text">

                <h5>{props.professorName}</h5>
                <p dangerouslySetInnerHTML={{__html: props.professorContent}}></p>
                <p><strong><a href={props.professorLink}>Learn more about {props.professorName}»</a></strong></p>
            </div>
        </div>
    )
}