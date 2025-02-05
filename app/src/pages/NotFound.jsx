import error from '../assets/error.jpg'

/**
 * NotFound
 * 
 * This component is for the page that is displayed
 * if a user types in an incorrect url. They will
 * be redirected to a 404 Page Not Found.
 * 
 * @author Luke Walpole W20020794
 */

function NotFound() {
    return (
        <>
            <h1 className='text-4xl text-red text-center p-5'>404</h1>
            <p className='text-2xl text-blue text-center p-5'>Page Not Found!</p>
            <img className="h-48 w-96 mx-auto shadow-xl dark:shadow-gray-800"src={error}  alt="Error Logo" />
            <p className='text-blue text-center p-5'>Photo by Miguel Á. Padriñán: https://www.pexels.com/photo/close-up-shot-of-keyboard-buttons-2882552/</p>
        </>
    )
}
 
export default NotFound