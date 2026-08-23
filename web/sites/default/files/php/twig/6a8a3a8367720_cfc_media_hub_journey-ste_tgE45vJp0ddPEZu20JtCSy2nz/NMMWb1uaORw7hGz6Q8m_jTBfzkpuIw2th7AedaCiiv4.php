<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:journey-steps */
class __TwigTemplate_4035513a47448b18bf2cd7153caf87fa extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--journey-steps"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:journey-steps"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:journey-steps"));
        $context["labels"] = ["Account", "Space", "Date & Time", "Review", "Payment"];
        // line 2
        $context["first_active"] = Twig\Extension\CoreExtension::first($this->env->getCharset(), ($context["active"] ?? null));
        // line 3
        $context["last_active"] = Twig\Extension\CoreExtension::last($this->env->getCharset(), ($context["active"] ?? null));
        // line 4
        yield "<div class=\"flex items-center gap-2\">
  ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["labels"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["label"]) {
            // line 6
            yield "    ";
            $context["n"] = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 6);
            // line 7
            yield "    ";
            $context["done"] = (($context["n"] ?? null) < ($context["first_active"] ?? null));
            // line 8
            yield "    ";
            $context["is_active"] = CoreExtension::inFilter(($context["n"] ?? null), ($context["active"] ?? null));
            // line 9
            yield "    <div class=\"flex items-center gap-2\">
      <div class=\"flex items-center gap-2\">
        <div class=\"w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-semibold transition-all ";
            // line 11
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = ($context["done"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("bg-[#0F6E56] text-white") : ((((($tmp = ($context["is_active"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("bg-[#9F5434] text-white") : ("bg-neutral-100 text-neutral-400")))));
            yield "\">
          ";
            // line 12
            if ((($tmp = ($context["done"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 13
                yield "            ";
                yield from $this->load("cfc_media_hub:icon", 13)->unwrap()->yield(CoreExtension::toArray(["name" => "check", "size" => "w-3.5 h-3.5"]));
                // line 14
                yield "          ";
            } else {
                // line 15
                yield "            ";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["n"] ?? null), "html", null, true);
                yield "
          ";
            }
            // line 17
            yield "        </div>
        <span class=\"text-[12px] hidden md:block ";
            // line 18
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = ($context["is_active"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("text-[#9F5434] font-semibold") : ((((($tmp = ($context["done"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("text-[#0F6E56]") : ("text-neutral-400")))));
            yield "\">
          ";
            // line 19
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["label"], "html", null, true);
            yield "
        </span>
      </div>
      ";
            // line 22
            if ( !(($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, true, 22)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 23
                yield "        <div class=\"w-8 h-px mx-1 ";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = ($context["done"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("bg-[#0F6E56]") : (((((($tmp = ($context["is_active"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp) && CoreExtension::inFilter((($context["n"] ?? null) + 1), ($context["active"] ?? null)))) ? ("bg-[#9F5434]") : ("bg-neutral-200")))));
                yield "\"></div>
      ";
            }
            // line 25
            yield "    </div>
  ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['label'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 27
        yield "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["active", "loop"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:journey-steps";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  141 => 27,  125 => 25,  119 => 23,  117 => 22,  111 => 19,  107 => 18,  104 => 17,  98 => 15,  95 => 14,  92 => 13,  90 => 12,  86 => 11,  82 => 9,  79 => 8,  76 => 7,  73 => 6,  56 => 5,  53 => 4,  51 => 3,  49 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:journey-steps", "themes/custom/cfc_media_hub/components/journey-steps/journey-steps.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 1, "for" => 5, "if" => 12, "include" => 13];
        static $filters = ["first" => 2, "last" => 3, "escape" => 15];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "set", 1 => "for", 2 => "if", 3 => "include"],
                [0 => "first", 1 => "last", 2 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
