import { useEffect, useState } from 'react'

/**
 * Country
 * 
 * This is a component that allows the user to
 * display additional information from the api.
 * If the user clicks on a country, the cities
 * and institutions from that country will also
 * be displayed.
 * 
 * @author Luke Walpole W20020794
 */
 
function Country(props) {
    const [visible, setVisible] = useState(false)
 
 
    return (
        <section className='bg-grey text-blue h-24 overflow-scroll m-2 p-2 rounded-md border-red border-2'>
            <h2 onClick={() => setVisible( visible => !visible )}>{props.country.country}</h2>
            {visible && <p>{props.country.city}</p>}
            {visible && <p>{props.country.institution}</p>}
        </section>
    )
}

export default Country;