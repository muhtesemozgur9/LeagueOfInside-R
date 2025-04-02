import React from "react";
import PropTypes from "prop-types";
import styles from "./Button.module.css";

const Button = ({ children, onClick, type = "button", disabled = false }) => {
  return (
    <button
      type={type}
      className={styles.button}
      onClick={onClick}
      disabled={disabled}
    >
      {children}
    </button>
  );
};

Button.propTypes = {
  children: PropTypes.node.isRequired, 
  onClick: PropTypes.func,
  type: PropTypes.string,
  disabled: PropTypes.bool,
};

Button.defaultProps = {
  onClick: () => {},
  type: "button",
  disabled: false,
};

export default Button;
