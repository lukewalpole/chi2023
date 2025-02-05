import { useEffect, useState } from 'react'

/**
 * Content
 * 
 * This is a component that allows the user to
 * display additional information from the api.
 * If the user clicks on a piece of content,
 * the abstract, content type, authors names,
 * affiliations and whether is has won an award
 * or not will be displayed.
 * 
 * @author Luke Walpole W20020794
 */
 
function Content(props) {
    const [visible, setVisible] = useState(false)
 
 
    return (
        <section className='bg-grey text-blue h-24 overflow-scroll m-2 p-2 rounded-md border-red border-2'>
            <h2 onClick={() => setVisible(visible => !visible)}>{props.content.title}</h2>
            {visible && <>
            <p>{props.content.abstract}</p>
            <p>{props.content.type_name}</p>
            </>}
        </section>
    )
}

export default Content;