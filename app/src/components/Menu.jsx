import { Link } from 'react-router-dom';
 
/**
 * Main menu
 * 
 * This will be the main navigation component in 
 * the app, with links to all main pages.
 * 
 * @author Luke Walpole W20020794
 */

function Menu() {
    return (
        <nav className='bg-peach text-blue text-center  p-5 border-b-2'>
            <ul className='flex flex-col md:flex-row justify-evenly'>
                <li className='py-2 px-8 hover:bg-grey rounded'><Link to="/">Home</Link></li>
                <li className='py-2 px-8 hover:bg-grey rounded'><Link to="/country">Countries</Link></li>
                <li className='py-2 px-8 hover:bg-grey rounded'><Link to="/content">Content</Link></li>
            </ul>
        </nav>
    )
}
 
export default Menu;