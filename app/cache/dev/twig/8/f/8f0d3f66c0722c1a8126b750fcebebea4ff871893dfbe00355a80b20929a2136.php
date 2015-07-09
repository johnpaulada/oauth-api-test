<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_8f0d3f66c0722c1a8126b750fcebebea4ff871893dfbe00355a80b20929a2136 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_76c5337968021605c37095d40900a306e773c2e3d8f7d97612ed340b624a13de = $this->env->getExtension("native_profiler");
        $__internal_76c5337968021605c37095d40900a306e773c2e3d8f7d97612ed340b624a13de->enter($__internal_76c5337968021605c37095d40900a306e773c2e3d8f7d97612ed340b624a13de_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_76c5337968021605c37095d40900a306e773c2e3d8f7d97612ed340b624a13de->leave($__internal_76c5337968021605c37095d40900a306e773c2e3d8f7d97612ed340b624a13de_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_cfd5a0ffd236ecd9f3ac74c3af54e05092c897db37bd503ef119b51c38b63da6 = $this->env->getExtension("native_profiler");
        $__internal_cfd5a0ffd236ecd9f3ac74c3af54e05092c897db37bd503ef119b51c38b63da6->enter($__internal_cfd5a0ffd236ecd9f3ac74c3af54e05092c897db37bd503ef119b51c38b63da6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_cfd5a0ffd236ecd9f3ac74c3af54e05092c897db37bd503ef119b51c38b63da6->leave($__internal_cfd5a0ffd236ecd9f3ac74c3af54e05092c897db37bd503ef119b51c38b63da6_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_aa31478ff0ec3ca5d7ffe57ddf8396105120c067d0a5e2400a33133dbf93a574 = $this->env->getExtension("native_profiler");
        $__internal_aa31478ff0ec3ca5d7ffe57ddf8396105120c067d0a5e2400a33133dbf93a574->enter($__internal_aa31478ff0ec3ca5d7ffe57ddf8396105120c067d0a5e2400a33133dbf93a574_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_aa31478ff0ec3ca5d7ffe57ddf8396105120c067d0a5e2400a33133dbf93a574->leave($__internal_aa31478ff0ec3ca5d7ffe57ddf8396105120c067d0a5e2400a33133dbf93a574_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_41a92f4de058788c29f1b3b8322301e103d2973ab9981b917a9a0aea14c9e8cb = $this->env->getExtension("native_profiler");
        $__internal_41a92f4de058788c29f1b3b8322301e103d2973ab9981b917a9a0aea14c9e8cb->enter($__internal_41a92f4de058788c29f1b3b8322301e103d2973ab9981b917a9a0aea14c9e8cb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_41a92f4de058788c29f1b3b8322301e103d2973ab9981b917a9a0aea14c9e8cb->leave($__internal_41a92f4de058788c29f1b3b8322301e103d2973ab9981b917a9a0aea14c9e8cb_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
