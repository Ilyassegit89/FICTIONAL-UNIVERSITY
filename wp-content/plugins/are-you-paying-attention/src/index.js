import React from 'react';
import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon } from "@wordpress/components";
import "./index.scss";

(function ourStartFunction() {
    let locked = false;

    wp.data.subscribe(function() {
        const results = wp.data.select("core/block-editor").getBlocks().filter(function(block) {
            return block.name == 'ourplugin/are-you-paying-attention' && block.attributes.correctAnswer == undefined;
        });
        
        if (results.length && locked == false) {
            locked = true;
            wp.data.dispatch("core/editor").lockPostSaving("noanswer");
        }
        
        if (!results.length && locked) {
            locked = false;
            wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
        }
    });
})();

wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: "Are You Paying Attention",
    icon: "smiley",
    category: "common",
    attributes: {
        question: { type: "string" },
        answers: { type: "array", default: [""] },
        correctAnswer: { type: "number", default: undefined }
    },
    edit: EditComponent,
    save: function(props) {
        return null;
    }
});

function EditComponent(props) {
    const { attributes, setAttributes } = props;
    const { question, answers, correctAnswer } = attributes;

    function updateQuestion(value) {
        setAttributes({ question: value });
    }

    function deleteAnswer(indexToDelete) {
        const newAnswers = answers.filter((x, index) => index !== indexToDelete);
        setAttributes({ answers: newAnswers });
        
        if (indexToDelete === correctAnswer) {
            setAttributes({ correctAnswer: undefined });
        }
    }

    function markAsCorrect(index) {
        setAttributes({ correctAnswer: index });
    }

    function updateAnswer(index, newValue) {
        const newAnswers = [...answers];
        newAnswers[index] = newValue;
        setAttributes({ answers: newAnswers });
    }

    function addAnswer() {
        setAttributes({ answers: [...answers, ""] });
    }

    return (
        <div className="paying-attention-edit-block">
            <TextControl 
                label="Question:" 
                value={question || ''} 
                onChange={updateQuestion} 
                style={{ fontSize: '20px' }} 
            />
            
            <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>
                Answers:
            </p>
            
            {answers.map((answer, index) => (
                <Flex key={index} style={{ marginBottom: '10px' }}>
                    <FlexBlock>
                        <TextControl 
                            value={answer} 
                            onChange={(newValue) => updateAnswer(index, newValue)} 
                            placeholder={`Answer ${index + 1}`}
                        />
                    </FlexBlock>
                    
                    <FlexItem>
                        <Button 
                            onClick={() => markAsCorrect(index)}
                            title={correctAnswer === index ? 'Correct answer' : 'Mark as correct'}
                        >
                            <Icon 
                                className="mark-as-correct" 
                                icon={correctAnswer === index ? "star-filled" : "star-empty"} 
                            />
                        </Button>
                    </FlexItem>
                    
                    <FlexItem>
                        <Button 
                            isLink 
                            className="attention-delete" 
                            onClick={() => deleteAnswer(index)}
                            isDestructive
                        >
                            Delete
                        </Button>
                    </FlexItem>
                </Flex>
            ))}
            
            <Button 
                onClick={addAnswer} 
                isPrimary
                style={{ marginTop: '10px' }}
            >
                Add another answer
            </Button>

            {/* Preview */}
            {question && answers.length > 0 && (
                <div className="quiz-preview" style={{ marginTop: '20px', padding: '15px', background: '#f0f0f0', borderRadius: '4px' }}>
                    <h4>Preview:</h4>
                    <p><strong>{question}</strong></p>
                    <ul>
                        {answers.map((answer, index) => (
                            <li key={index} style={{ 
                                color: correctAnswer === index ? 'green' : 'inherit',
                                fontWeight: correctAnswer === index ? 'bold' : 'normal'
                            }}>
                                {answer} {correctAnswer === index && '✓'}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}