import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"

wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: "Are You Paying Attention",
    icon: "smiley",
    category: "common",
    attributes: {
        skyColor: {type: "string"},
        grassColor: {type: "string"}
    },
    edit: EditComponent,
    save: function (props) {
         return null
    },
    
})
function EditComponent(props){
    
        function updateSkyColor(event){
            props.setAttributes({skyColor: event.target.value})
        }
        function updateGraceColor(event){
            props.setAttributes({grassColor: event.target.value})
        }

        return (
            <div className="paying-attention-edit-block">
                <TextControl label="Question:" />
                <p>Answers</p>
                <Flex>
                    <FlexBlock>
                        <TextControl label="Question:" />
                    </FlexBlock>
                    <FlexItem>
                        <Button>
                            <Icon icon="star-empty"></Icon>
                        </Button>
                    </FlexItem>
                    <FlexItem>
                        <Button>Delete</Button>
                    </FlexItem>

                </Flex>
            </div>
        )
    
}