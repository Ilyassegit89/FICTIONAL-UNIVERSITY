wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: "Are You Paying Attention",
    icon: "smiley",
    category: "common",
    attributes: {
        skyColor: {type: "string"},
        grassColor: {type: "string"}
    },
    edit: function (props) {
        function updateSkyColor(event){
            props.setAttributes({skyColor: event.target.value})
        }
        function updateGraceColor(event){
            props.setAttributes({grassColor: event.target.value})
        }

        return (
            <div>
                <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor}/>
                <input type="text" placeholder="grace color" value={props.attributes.grassColor} onChange={updateGraceColor}/>
            </div>
        )
    },
    save: function (props) {
         return (
            <>
            <p>Today the sky is {props.attributes.skyColor} and grass is {props.attributes.grassColor} </p>
            </>  
         )

    }
})